<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;

class Company
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $phraseBuilder;
    private $builder;
    private $language;


    public function __construct()
    {
        !checkLogin() ? redirect("adminpanel/Auth-signin") : null;

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language=getLanguage();

    }


    public function act($act, $option = '')
    {
        if ($act == "createCompany") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.company.create", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "createCompanyProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                newRequest('link', $_POST['link']);
                $link = sanitizeInput($_POST['link']);

                $image = '';

                $imageAlt = sanitizeInputNonEn($_POST['companyImageAlt']);

                if (empty(getErrors())) {
                    if (!empty($_FILES['companyImage']) and !empty($_FILES['companyImage']['name'])) {
                        $company_image = $_FILES['companyImage'];

                        if (empty(getErrors())) {
                            $image = file_upload($company_image, 'company', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($image == '') {
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            }
                        }
                    }


                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Company-createCompany?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerCompany($imageAlt, $image, $link);

                    redirect('adminpanel/Company-companyList?success=true');
                }

            }
        }

        if ($act == "companyList") {

            $companies = $this->getCompanies();
            renderView("admin.$this->language.company.list", ['companies' => $companies]);

        }

        if ($act == "getCompanyDetails") {
            $company_id = sanitizeInput($_POST['company_id']);
            $company_info = $this->getCompany($company_id)[0];

            $result = '';
            if ($company_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">image</th>';
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $company_info["image"] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">alt</th>';
                $result .= '<td>' . $company_info["alt"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">link</th>';
                $result .= '<td>' . $company_info["link"] . '</td>';
                $result .= "</tr>";

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "companyDelete") {

            $company_id = $option;
            $company_info = $this->getCompany($company_id)[0];
            destroy_file($company_info['image']);

            $this->deleteCompany($company_id);

            redirect('adminpanel/Company-companyList?success=true');
        }

        if ($act == "companyIsShow") {
            $company_id = sanitizeInput($_POST['company_id']);
            $situation = sanitizeInput($_POST['situation']);

            $this->updateCompanyIsShow($company_id, $situation);
            echo true;
        }

        if ($act == "editCompany") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $company_id = $option;
            $company = $this->getCompany($company_id)[0];

            renderView("admin.$this->language.company.edit", ['token' => $token, 'company' => $company]);
        }

        if ($act == "editCompanyProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                newRequest('link', $_POST['link']);
                $link = sanitizeInput($_POST['link']);

                $company_id = sanitizeInput($_POST['company_id']);
                $company = $this->getCompany($company_id)[0];
                $image = '';

                $imageAlt = sanitizeInputNonEn($_POST['companyImageAlt']);

                if (empty(getErrors())) {
                    if (!empty($_FILES['companyImage']) and !empty($_FILES['companyImage']['name'])) {
                        $company_image = $_FILES['companyImage'];

                        $image = file_upload($company_image, 'company', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($image == '') {
                            setError('تصویر را با فرمت صحیح وارد کنید');
                        } else {
                            destroy_file($company['image']);
                        }

                    }


                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Company-editCompany-'.$company_id.'?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->editCompany($company_id,$imageAlt, $image, $link);

                    redirect('adminpanel/Company-companyList?success=true');
                }

            }
        }

    }

    private function getCompanies()
    {
        return $this->db->select_q("companies", [], "order by id desc");
    }

    private function registerCompany($imageAlt, $image, $link)
    {
        $data = [
            'image' => $image,
            'alt' => $imageAlt,
            'created_at_jalali' => CalendarUtils::strftime("Y/m/d H:i:s"),
            'created_at' => date("Y/m/d H:i:s"),
            'link' => $link

        ];

        return $this->db->insert("companies", $data);
    }

    private function getCompany($company_id)
    {
        $data = [
            'id' => $company_id
        ];
        return $this->db->select_q("companies", $data);
    }

    private function deleteCompany($company_id)
    {
        $query = "delete from `companies` where `id`='" . $company_id . "' limit 1";
        return $this->db->select_old($query);
    }

    private function updateCompanyIsShow($company_id, $situation)
    {
        $data = [
            'is_show' => $situation
        ];

        return $this->db->update("companies", $data, 'id="' . $company_id . '"');
    }

    private function editCompany($company_id, $imageAlt, $image, $link)
    {
        $data = [
            'link' => $link

        ];
        if($image){
            $data['image']= $image;
            $data['alt']= $imageAlt;
        }

        return $this->db->update("companies", $data,"id='".$company_id."'");
    }


}