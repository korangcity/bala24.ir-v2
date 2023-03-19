<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Setting
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
        $this->pages = [1 => "وبلاگ", 2 => "سرویس", 3 => "نمونه سرویس", 4 => "خبر", 5 => "صفحات", 6 => "صفحه اصلی"];
    }

    public function act($act, $option = '')
    {
        if ($act == 'changeLanguage') {

            $this->language = sanitizeInput($option);
            if (in_array($this->language, ['en', 'fa', 'ar'])){
                setLanguage($this->language);

            }
            back();
        }

        if($act=="uploadCkeditorFile"){
            if (!empty($_FILES['upload']) and $_FILES['upload']['name'] != '') {
                $category_image = $_FILES['upload'];
                $image = file_upload($category_image, 'ckeditor', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);

                $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
                $url = baseUrl(httpCheck()).$image;
                $msg = 'تصویر با موفقیت آپلود شد';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction( $CKEditorFuncNum,'$url', '$msg')</script>";

                @header('Content-type: text/html; charset=utf-8');
                echo $response;
            }
        }

        if ($act == "createGeneralInformation") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.setting.create", ['token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "createGeneralInformationProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('location', $_POST['location']);
                newRequest('phone3', $_POST['phone3']);
                newRequest('phone2', $_POST['phone2']);
                newRequest('phone1', $_POST['phone1']);
                newRequest('email', $_POST['email']);
                newRequest('linkedin', $_POST['linkedin']);
                newRequest('whatsapp', $_POST['whatsapp']);
                newRequest('instagram', $_POST['instagram']);
                newRequest('telegram', $_POST['telegram']);
                newRequest('address', $_POST['address']);

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

//                if ($_POST['captcha'] != $_SESSION['phrase']) {
//                    setError('مقدار کپچا را به درستی وارد کنید');
//
//                }

                $location = $_POST['location']??"";
                $phone3 = sanitizeInput($_POST['phone3'])??"";
                $phone2 = sanitizeInput($_POST['phone2'])??"";
                $phone1 = sanitizeInput($_POST['phone1'])??"";
                $email = sanitizeInput($_POST['email'])??"";
                $linkedin = sanitizeInput($_POST['linkedin'])??"";
                $whatsapp = sanitizeInput($_POST['whatsapp'])??"";
                $instagram = sanitizeInput($_POST['instagram'])??"";
                $telegram = sanitizeInput($_POST['telegram'])??"";
                $address = sanitizeInputNonEn($_POST['address'])??"";

//                if ($location!="" and !urlVerify($location)) {
//                    setError('لوکیشن را صحیح وارد کنید');
//                }

                if (strlen($phone3) > 0 and !is_numeric($phone3)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($phone2) > 0 and !is_numeric($phone2)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($phone1) > 0 and !is_numeric($phone1)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($linkedin) > 0 and !urlVerify($linkedin)) {
                    setError('آدرس لینکدین را به درستی وارد کنید');
                }

                if (strlen($whatsapp) > 0 and !urlVerify($whatsapp)) {
                    setError('آدرس واتس آپ را به درستی وارد کنید');
                }

                if (strlen($instagram) > 0 and !urlVerify($instagram)) {
                    setError('آدرس اینستاگرام را به درستی وارد کنید');
                }

                if (strlen($telegram) > 0 and !urlVerify($telegram)) {
                    setError('آدرس تلگرام را به درستی وارد کنید');
                }

                if ($email != "" and !emailVerify($email)) {
                    setError('ایمیل را صحیح وارد کنید');
                }

                $image = '';

                $logoAlt = sanitizeInputNonEn($_POST['logoAlt']);;

                if (empty(getErrors())) {
                    if (!empty($_FILES['logo']) and !empty($_FILES['logo']['name'])) {
                        $logo = $_FILES['logo'];

                        if (empty(getErrors())) {
                            $image = file_upload($logo, 'setting', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($image == '') {
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            }
                        }
                    }

                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Setting-createGeneralInformation?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerSetting($location, $address, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $logoAlt, $image);

                    redirect('adminpanel/Setting-GeneralInformation?success=true');
                }

            }
        }

        if ($act == "GeneralInformationList") {

            $setting = $this->getSetting()[0];

            renderView("admin.$this->language.setting.list", ['setting' => $setting]);
        }

        if ($act == "getSettingDetails") {

            $setting_info = $this->getSetting()[0];

            $result = '';
            if ($setting_info) {

                $result .= "<tbody>";

                $result .= "<tr>";
                $result .= '<th scope="row">phone1</th>';
                $result .= '<td>' . $setting_info["phone1"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">phone2</th>';
                $result .= '<td>' . $setting_info["phone2"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">phone3</th>';
                $result .= '<td>' . $setting_info["phone3"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">telegram</th>';
                $result .= '<td>' . $setting_info["telegram"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">instagram</th>';
                $result .= '<td>' . $setting_info["instagram"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">linkedin</th>';
                $result .= '<td>' . $setting_info["linkedin"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">whatsapp</th>';
                $result .= '<td>' . $setting_info["whatsapp"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">email</th>';
                $result .= '<td>' . $setting_info["email"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">location</th>';
                $result .= '<td>' . $setting_info["location"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">address</th>';
                $result .= '<td>' . $setting_info["address"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">عنوان درباره ما در فوتر</th>';
                $result .= '<td>' . $setting_info["footer_aboutus_title"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row"> درباره ما در فوتر</th>';
                $result .= '<td>' . $setting_info["footer_aboutus"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">متن قسمت چسبیده به فوتر</th>';
                $result .= '<td>' . $setting_info["stick_footer_text"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">آیکن قسمت چسبیده به فوتر</th>';
                $result .= '<td><i class="'.$setting_info["stick_footer_icon"].' fs-36 text-info"></i></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">لینک قسمت چسبیده به فوتر</th>';
                $result .= '<td>' . $setting_info["stick_footer_link"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">متن دکمه قسمت چسبیده به فوتر</th>';
                $result .= '<td>' . $setting_info["stick_footer_title"] . '</td>';
                $result .= "</tr>";

                $result .= "<tr>";
                $result .= "<td>تصویر لوگو بزرگ تاریک</td>";
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $setting_info['large_logo_dark'] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= "<td>alt</td>";
                $result .= '<td>' . $setting_info['large_logo_dark_alt'] . '</td>';
                $result .= "</tr>";

                $result .= "<tr>";
                $result .= "<td>تصویر لوگو کوچک تاریک</td>";
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $setting_info['small_logo_dark'] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= "<td>alt</td>";
                $result .= '<td>' . $setting_info['small_logo_dark_alt'] . '</td>';
                $result .= "</tr>";

                $result .= "<tr>";
                $result .= "<td>تصویر لوگو بزرگ روشن</td>";
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $setting_info['large_logo_light'] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= "<td>alt</td>";
                $result .= '<td>' . $setting_info['large_logo_light_alt'] . '</td>';
                $result .= "</tr>";


                $result .= "<tr>";
                $result .= "<td>تصویر لوگو کوچک روشن</td>";
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $setting_info['small_logo_light'] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= "<td>alt</td>";
                $result .= '<td>' . $setting_info['small_logo_light_alt'] . '</td>';
                $result .= "</tr>";


                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "editGeneralInformation") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $setting = $this->getSetting()[0];


            renderView("admin.$this->language.setting.edit", ['setting' => $setting, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "editGeneralInformationProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('location', $_POST['location']);
                newRequest('phone3', $_POST['phone3']);
                newRequest('phone2', $_POST['phone2']);
                newRequest('phone1', $_POST['phone1']);
                newRequest('email', $_POST['email']);
                newRequest('linkedin', $_POST['linkedin']);
                newRequest('whatsapp', $_POST['whatsapp']);
                newRequest('instagram', $_POST['instagram']);
                newRequest('telegram', $_POST['telegram']);
                newRequest('address', $_POST['address']);

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

//                if ($_POST['captcha'] != $_SESSION['phrase']) {
//                    setError('مقدار کپچا را به درستی وارد کنید');
//
//                }

                $location = $_POST['location'];
                $phone3 = sanitizeInput($_POST['phone3']);
                $phone2 = sanitizeInput($_POST['phone2']);
                $phone1 = sanitizeInput($_POST['phone1']);
                $email = sanitizeInput($_POST['email']);
                $linkedin = sanitizeInput($_POST['linkedin']);
                $whatsapp = sanitizeInput($_POST['whatsapp']);
                $instagram = sanitizeInput($_POST['instagram']);
                $telegram = sanitizeInput($_POST['telegram']);
                $address = sanitizeInputNonEn($_POST['address']);
                $index_service_title = sanitizeInputNonEn($_POST['index_service_title']);
                $index_service_description = sanitizeInputNonEn($_POST['index_service_description']);
                $index_company_title = sanitizeInputNonEn($_POST['index_company_title']);
                $index_satisfy_title = sanitizeInputNonEn($_POST['index_satisfy_title']);
                $index_functionality_titles1 = sanitizeInputNonEn($_POST['index_functionality_titles1']);
                $index_functionality_values1 = sanitizeInputNonEn($_POST['index_functionality_values1']);
                $index_functionality_titles2 = sanitizeInputNonEn($_POST['index_functionality_titles2']);
                $index_functionality_values2 = sanitizeInputNonEn($_POST['index_functionality_values2']);
                $index_functionality_titles3 = sanitizeInputNonEn($_POST['index_functionality_titles3']);
                $index_functionality_values3 = sanitizeInputNonEn($_POST['index_functionality_values3']);
                $index_functionality_titles4 = sanitizeInputNonEn($_POST['index_functionality_titles4']);
                $index_functionality_values4 = sanitizeInputNonEn($_POST['index_functionality_values4']);
                $footer_aboutus_title = sanitizeInputNonEn($_POST['footer_aboutus_title']);
                $footer_aboutus = sanitizeInputNonEn($_POST['footer_aboutus']);

                $func_array_titles=[$index_functionality_titles1,$index_functionality_titles2,$index_functionality_titles3,$index_functionality_titles4];
                $func_array_value=[$index_functionality_values1,$index_functionality_values2,$index_functionality_values3,$index_functionality_values4];

                $func_array_titles=json_encode($func_array_titles);
                $func_array_value=json_encode($func_array_value);

//                if (strlen($location) > 0 and !urlVerify($location)) {
//                    setError('لوکیشن را صحیح وارد کنید');
//                }

                if (strlen($phone3) > 0 and !is_numeric($phone3)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($phone2) > 0 and !is_numeric($phone2)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($phone1) > 0 and !is_numeric($phone1)) {
                    setError('شماره تماس را به درستی وارد کنید');
                }

                if (strlen($linkedin) > 0 and !urlVerify($linkedin)) {
                    setError('آدرس لینکدین را به درستی وارد کنید');
                }

                if (strlen($whatsapp) > 0 and !urlVerify($whatsapp)) {
                    setError('آدرس واتس آپ را به درستی وارد کنید');
                }

                if (strlen($instagram) > 0 and !urlVerify($instagram)) {
                    setError('آدرس اینستاگرام را به درستی وارد کنید');
                }

                if (strlen($telegram) > 0 and !urlVerify($telegram)) {
                    setError('آدرس تلگرام را به درستی وارد کنید');
                }

                if ($email != "" and !emailVerify($email)) {
                    setError('ایمیل را صحیح وارد کنید');
                }

                $setting = $this->getSetting()[0];

                $largeLogoDark = '';
                $smallLogoDark = '';
                $largeLogoLight = '';
                $smallLogoLight = '';


                $largeLogoDarkAlt = sanitizeInputNonEn($_POST['largeLogoDarkAlt']);
                $smallLogoDarkAlt = sanitizeInputNonEn($_POST['smallLogoDarkAlt']);
                $largeLogoLightAlt = sanitizeInputNonEn($_POST['largLogoLightAlt']);
                $smallLogoLightAlt = sanitizeInputNonEn($_POST['smallLogoLightAlt']);
                if (empty(getErrors())) {

                    if (!empty($_FILES['largeLogoDark']) and !empty($_FILES['largeLogoDark']['name'])) {
                        $largeLogoDarkk = $_FILES['largeLogoDark'];

                        if (empty(getErrors())) {
                            $largeLogoDark = file_upload($largeLogoDarkk, 'setting', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($largeLogoDark == '') {
                                setError('تصویر لوگوی بزرگ تاریک را با فرمت صحیح وارد کنید');
                            }else{
                                destroy_file($setting[0]['large_logo_dark']);

                            }
                        }
                    }

                    if (!empty($_FILES['smallLogoDark']) and !empty($_FILES['smallLogoDark']['name'])) {
                        $smallLogoDarkk = $_FILES['smallLogoDark'];

                        if (empty(getErrors())) {
                            $smallLogoDark = file_upload($smallLogoDarkk, 'setting', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($smallLogoDark == '') {
                                setError('تصویر لوگوی کوچک تاریک را با فرمت صحیح وارد کنید');
                            }else{
                                destroy_file($setting[0]['small_logo_dark']);

                            }
                        }
                    }

                    if (!empty($_FILES['largeLogoLight']) and !empty($_FILES['largeLogoLight']['name'])) {
                        $largeLogoLightt = $_FILES['largeLogoLight'];

                        if (empty(getErrors())) {
                            $largeLogoLight= file_upload($largeLogoLightt, 'setting', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($largeLogoLight == '') {
                                setError('تصویر لوگوی بزرگ روشن را با فرمت صحیح وارد کنید');
                            }else{
                                destroy_file($setting[0]['large_logo_light']);

                            }
                        }
                    }

                    if (!empty($_FILES['smallLogoLight']) and !empty($_FILES['smallLogoLight']['name'])) {
                        $smallLogoLightt = $_FILES['smallLogoLight'];

                        if (empty(getErrors())) {
                            $smallLogoLight= file_upload($smallLogoLightt, 'setting', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($smallLogoLight == '') {
                                setError('تصویر لوگوی کوچک روشن را با فرمت صحیح وارد کنید');
                            }else{
                                destroy_file($setting[0]['large_logo_light']);

                            }
                        }
                    }


                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Setting-editGeneralInformation'.$setting[0]['id'].'?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->updateSetting($location, $address, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $largeLogoDark,$smallLogoDark,$largeLogoLight,$smallLogoLight,$largeLogoDarkAlt,$smallLogoDarkAlt,$largeLogoLightAlt,$smallLogoLightAlt,$index_service_title,$index_service_description,$index_company_title,$index_satisfy_title,$func_array_titles,$func_array_value,$footer_aboutus_title,$footer_aboutus);

                    redirect('adminpanel/Setting-GeneralInformationList?success=true');
                }

            }
        }

        if ($act == "settingDeleteImage") {

            $setting_id = sanitizeInput($_POST['setting_id']);
            $setting_info = $this->getSetting()[0];
            destroy_file($setting_info['logo']);
            $this->updateSettingLogo();
            echo true;

        }

        if($act=="icons"){
            renderView("admin.$this->language.setting.icons");
        }


    }

    private function registerSetting($location, $address, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $logoAlt, $image)
    {
        $data = [
            'location' => $location,
            'phone3' => $phone3,
            'phone2' => $phone2,
            'phone1' => $phone1,
            'email' => $email,
            'linkedin' => $linkedin,
            'whatsapp' => $whatsapp,
            'address' => $address,
            'telegram' => $telegram,
            'instagram' => $instagram,
            'logoAlt' => $logoAlt
        ];

        if ($image != '') {
            $data['logo'] = $image;
        }

        return $this->db->insert("setting", $data);
    }

    public function getSetting()
    {
        $data = [
            'id' => 1
        ];
        return $this->db->select_q("setting", $data);
    }

    private function updateSettingLogo()
    {
        $data = [
            'logo' => "",
            'logoAlt' => ""
        ];

        return $this->db->update("setting", $data, "id=1");
    }

    private function updateSetting( $location, $address, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $largeLogoDark,$smallLogoDark,$largeLogoLight,$smallLogoLight,$largeLogoDarkAlt,$smallLogoDarkAlt,$largeLogoLightAlt,$smallLogoLightAlt,$index_service_title,$index_service_description,$index_company_title,$index_satisfy_title,$func_array_titles,$func_array_value,$footer_aboutus_title,$footer_aboutus)
    {
        $data = [
            'location' => $location,
            'phone3' => $phone3,
            'phone2' => $phone2,
            'phone1' => $phone1,
            'email' => $email,
            'linkedin' => $linkedin,
            'whatsapp' => $whatsapp,
            'address' => $address,
            'telegram' => $telegram,
            'instagram' => $instagram,
            'index_service_title' => $index_service_title,
            'index_service_description' => $index_service_description,
            'index_company_title' => $index_company_title,
            'index_satisfy_title' => $index_satisfy_title,
            'index_functionality_titles' => $func_array_titles,
            'index_functionality_values' => $func_array_value,
            'footer_aboutus_title' => $footer_aboutus_title,
            'footer_aboutus' => $footer_aboutus
        ];

        if ($largeLogoDark != '') {
            $data['large_logo_dark'] = $largeLogoDark;
        }
        if ($largeLogoDarkAlt != '') {
            $data['large_logo_dark_alt'] = $largeLogoDarkAlt;
        }

        if ($smallLogoDark != '') {
            $data['small_logo_dark'] = $smallLogoDark;

        }
        if ($smallLogoDarkAlt != '') {
            $data['small_logo_dark_alt'] = $smallLogoDarkAlt;
        }

        if ($largeLogoLight != '') {
            $data['large_logo_light'] = $largeLogoLight;
        }

        if ($largeLogoLightAlt != '') {
            $data['large_logo_light_alt'] = $largeLogoLightAlt;
        }

        if ($smallLogoLight != '') {
            $data['small_logo_light'] = $smallLogoLight;
        }

        if ($smallLogoLightAlt != '') {
            $data['small_logo_light_alt'] = $smallLogoLightAlt;
        }



        return $this->db->update("setting", $data,"id=1");
    }

    private function registerStickFooterPages( $planable_type, $page_children)
    {
        foreach ($planable_type as $ke=>$item) {
            $data=[
                'pageable_type'=>$item,
                'pageable_id'=>$page_children[$ke]??''
            ];
            $this->db->insert("stick_footer_pages",$data);
        }
    }


}