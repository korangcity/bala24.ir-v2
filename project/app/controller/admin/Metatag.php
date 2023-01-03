<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Metatag
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $phraseBuilder;
    private $builder;
    public $routes;


    public function __construct()
    {

        !checkLogin() ? redirect("adminpanel/Auth-signin") : null;

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();

        $page=new Page();
        $pages=$page->getPages();

        $this->routes = [
            '/' => 'صفحه اصلی',
            '/products' => 'صفحه محصولات'
        ];

        foreach ($pages as $page) {
            $this->routes[$page["page_url"]]=$page['page_title_seo'];
        }
    }

    public function act($act, $option = '')
    {

        if ($act == "createMetatag") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            $metatags = $this->getMetatags();
            foreach ($metatags as $metatag) {
                unset($this->routes[$metatag['page_url']]);
            }
            $routesKey = array_keys($this->routes);
            renderView("admin.$this->language.metatag.create", ['routesKey' => $routesKey, 'routes' => $this->routes, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "createMetatagProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('pageUrl', $_POST['pageUrl']);
                newRequest('pageTitle', $_POST['pageTitle']);
                newRequest('pageTitle', $_POST['pageTitle']);
                newRequest('pageDescription', $_POST['pageDescription']);
                newRequest('pageKeywords', $_POST['pageKeywords']);
                newRequest('pageOgTitle', $_POST['pageOgTitle']);
                newRequest('pageOgDescription', $_POST['pageOgDescription']);
                newRequest('pageOgType', $_POST['pageOgType']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

//                if ($_POST['captcha'] != $_SESSION['phrase']) {
//                    setError('مقدار کپچا را به درستی وارد کنید');
//
//                }

                $pageUrl = sanitizeInputNonEn($_POST['pageUrl']);
                $pageTitle = sanitizeInputNonEn($_POST['pageTitle']);
                $pageDescription = sanitizeInputNonEn($_POST['pageDescription']);
                $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords'])));
                $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']);
                $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']);
                $pageOgType = sanitizeInputNonEn($_POST['pageOgType']);


                $imageOg = '';

                if (empty(getErrors())) {

                    if (!empty($_FILES['metatagOgImage']) and $_FILES['metatagOgImage']['name'] != '') {
                        $metatagOgImage = $_FILES['metatagOgImage'];
                        $imageOg = file_upload($metatagOgImage, 'metatag', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageOg == '') {
                            setError('تصویر را با فرمت صحیح وارد کنید');
                        }
                    }

                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Metatag-createMetatag?error=true');
                }

                if (empty(getErrors())) {

                    $res = $this->registerMetatag($pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageOg);
                    redirect('adminpanel/Metatag-metatagList');

                }
            }
        }

        if ($act == "metatagList") {

            $metatags = $this->getMetatags();
            renderView("admin.$this->language.metatag.list", ['routes' => $this->routes, 'metatags' => $metatags, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "editMetatag") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $routesKey = array_keys($this->routes);
            $metatag_id = sanitizeInput($option);
            $metatag = $this->getMetatag($metatag_id)[0];

            renderView("admin.$this->language.metatag.edit", ['metatag' => $metatag, 'routesKey' => $routesKey, 'routes' => $this->routes, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "editMetatagProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('pageUrl', $_POST['pageUrl']);
                newRequest('pageTitle', $_POST['pageTitle']);
                newRequest('pageTitle', $_POST['pageTitle']);
                newRequest('pageDescription', $_POST['pageDescription']);
                newRequest('pageKeywords', $_POST['pageKeywords']);
                newRequest('pageOgTitle', $_POST['pageOgTitle']);
                newRequest('pageOgDescription', $_POST['pageOgDescription']);
                newRequest('pageOgType', $_POST['pageOgType']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

//                if ($_POST['captcha'] != $_SESSION['phrase']) {
//                    setError('مقدار کپچا را به درستی وارد کنید');
//
//                }

                $pageUrl = sanitizeInputNonEn($_POST['pageUrl']);
                $pageTitle = sanitizeInputNonEn($_POST['pageTitle']);
                $pageDescription = sanitizeInputNonEn($_POST['pageDescription']);
                $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords'])));
                $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']);
                $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']);
                $pageOgType = sanitizeInputNonEn($_POST['pageOgType']);

                $metatag_id = sanitizeInput($_POST['metatag_id']);
                $metatag_info = $this->getMetatag($metatag_id)[0];
                $imageOg = '';

                if (empty(getErrors())) {

                    if (!empty($_FILES['metatagOgImage']) and $_FILES['metatagOgImage']['name'] != '') {
                        $metatagOgImage = $_FILES['metatagOgImage'];
                        $imageOg = file_upload($metatagOgImage, 'metatag', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);

                        if ($imageOg == '') {
                            setError('تصویر را با فرمت صحیح وارد کنید');
                        } else {
                            destroy_file($metatag_info['page_og_image_seo']);
                        }

                    }

                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Metatag-editMetatag-' . $metatag_id . '?error=true');
                }

                if (empty(getErrors())) {

                    $res = $this->editMetatag($metatag_id, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageOg);
                    redirect('adminpanel/Metatag-metatagList');

                }
            }
        }

        if ($act == "getMetatagSeoInfo") {
            $metatag_id = sanitizeInput($_POST['metatag_id']);
            $metatag_info = $this->getMetatag($metatag_id)[0];

            $result = '';
            if ($metatag_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $metatag_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $metatag_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $metatag_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $metatag_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $metatag_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $metatag_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $metatag_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $metatag_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "metatagDelete") {
            $metatag_id = $option;
            $metatag_info = $this->getMetatag($metatag_id)[0];

            destroy_file($metatag_info['page_og_image_seo']);

            $this->deleteMetatag($metatag_id);

            redirect('adminpanel/Metatag-metatagList?success=true');
        }

    }

    private function registerMetatag($pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageOg)
    {
        $data = [
            'created_at' => date("Y/m/d H:i:s"),
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_image_seo' => $imageOg,
            'page_og_type_seo' => $pageOgType
        ];

        return $this->db->insert('metatags', $data);
    }

    private function getMetatags()
    {
        return $this->db->select_q("metatags", [], "order by id desc");
    }

    private function getMetatag($metatag_id)
    {
        $data = [
            'id' => $metatag_id
        ];
        return $this->db->select_q("metatags", $data);
    }

    private function editMetatag($metatag_id, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageOg)
    {

        $data = [
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_type_seo' => $pageOgType
        ];

        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->update('metatags', $data, "id='" . $metatag_id . "'");

    }

    private function deleteMetatag($metatag_id)
    {
        $query = "delete from `metatags` where `id`='" . $metatag_id . "'";
        return $this->db->rawQuery($query);
    }

    public function getMetatagByUrl($pageUrl)
    {
        $data = [
            'page_url' => sanitizeInput($pageUrl)
        ];
        return $this->db->select_q("metatags", $data);
    }

}