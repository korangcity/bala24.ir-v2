<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;
 

class Page
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
        $this->language = getLanguage();
    }

    public function act($act, $option = '')
    {
        if ($act == "createPage") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.pages.create", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "createPageProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('h1_title', $_POST['h1_title']);
                newRequest('description', $_POST['description']);
                newRequest('keywords', $_POST['keywords']);
                newRequest('location', $_POST['location']);
                newRequest('phone3', $_POST['phone3']);
                newRequest('phone2', $_POST['phone2']);
                newRequest('phone1', $_POST['phone1']);
                newRequest('email', $_POST['email']);
                newRequest('linkedin', $_POST['linkedin']);
                newRequest('whatsapp', $_POST['whatsapp']);
                newRequest('instagram', $_POST['instagram']);
                newRequest('telegram', $_POST['telegram']);
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
//                    if ($this->language == 'en'):
//                        setError('enter captcha value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('مقدار کپچا را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل کلمة تحقیق بشكل صحيح');
//                    endif;
//
//                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $h1_title = sanitizeInput($_POST['h1_title']);
                    $keywords = sanitizeInput($_POST['keywords']);
                    $pageUrl = sanitizeInput($_POST['pageUrl']);
                    $pageTitle = sanitizeInput($_POST['pageTitle']);
                    $pageDescription = sanitizeInput($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInput($_POST['pageOgType']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $h1_title = sanitizeInputNonEn($_POST['h1_title']);
                    $keywords = sanitizeInputNonEn($_POST['keywords']);
                    $pageUrl = sanitizeInputNonEn($_POST['pageUrl']);
                    $pageTitle = sanitizeInputNonEn($_POST['pageTitle']);
                    $pageDescription = sanitizeInputNonEn($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInputNonEn($_POST['pageOgType']);
                endif;
                $location = $_POST['location'];
                $description = $_POST['description'];
                $phone3 = sanitizeInput($_POST['phone3']);
                $phone2 = sanitizeInput($_POST['phone2']);
                $phone1 = sanitizeInput($_POST['phone1']);
                $email = sanitizeInput($_POST['email']);
                $linkedin = sanitizeInput($_POST['linkedin']);
                $whatsapp = sanitizeInput($_POST['whatsapp']);
                $instagram = sanitizeInput($_POST['instagram']);
                $telegram = sanitizeInput($_POST['telegram']);

                if (strlen($brief_description) <= 10) {
                    if ($this->language == 'en'):
                        setError('The minimum length of the brief description is 10 characters.');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول توضیح مختصر 10 کاراکتر میباشد.');
                    elseif ($this->language == 'ar'):
                        setError('الحد الأدنى لطول الوصف المختصر هو 10 أحرف.');
                    endif;
                }

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

//                if (strlen($h1_title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter h1_title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان H1 را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان H1 بشكل صحيح');
//                    endif;
//                }

                if (strlen($description) <= 20) {
                    if ($this->language == 'en'):
                        setError('The minimum length of the description is 10 characters.');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
                    elseif ($this->language == 'ar'):
                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
                    endif;
                }

                if ($email != "" and !emailVerify($email)) {
                    if ($this->language == 'en'):
                        setError('Enter email correctly');
                    elseif ($this->language == 'fa'):
                        setError('ایمیل را صحیح وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل البريد الإلكتروني الصحيح');
                    endif;
                }

                $image = '';
                $imageOg = '';

                $imageAlts = [];

                foreach ($_POST['pageImageAlts'] as $pageImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($pageImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($pageImageAlt);
                    endif;
                }

                $imageAlts = json_encode($imageAlts);
                if (empty(getErrors())) {
                    if (!empty($_FILES['pageImages']) and !empty($_FILES['pageImages']['name'])) {
                        $page_image = $_FILES['pageImages'];
                        if (count($_FILES['pageImages']['name']) != count($_POST['pageImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($page_image, 'page', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($images == '') {
                                if ($this->language == 'en'):
                                    setError('enter image with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('تصویر را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل الصورة بالتنسيق الصحيح');
                                endif;
                            }
                        }
                    }

                    if (!empty($_FILES['pageOgImage']) and $_FILES['pageOgImage']['name'] != '') {
                        $page_image = $_FILES['pageOgImage'];
                        $imageOg = file_upload($page_image, 'page', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageOg == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        }
                    }

                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Page-createPage?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerPage($title, $brief_description, $description, $h1_title, $keywords, $location, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);

                    redirect('adminpanel/Page-pageList?success=true');
                }

            }
        }

        if ($act == "pageList") {
            $pages = $this->getPages($this->language);

            renderView("admin.$this->language.pages.list", ['pages' => $pages]);
        }

        if ($act == "getPageSeoInfo") {
            $page_id = sanitizeInput($_POST['page_id']);
            $page_info = $this->getPage($page_id)[0];

            $result = '';
            if ($page_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $page_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $page_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $page_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $page_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $page_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $page_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $page_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $page_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getPageDetails") {
            $page_id = sanitizeInput($_POST['page_id']);
            $page_info = $this->getPage($page_id)[0];

            $result = '';
            if ($page_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $page_info["keywords"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">h1_title</th>';
                $result .= '<td>' . $page_info["h1_title"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">phone1</th>';
                $result .= '<td>' . $page_info["phone1"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">phone2</th>';
                $result .= '<td>' . $page_info["phone2"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">phone3</th>';
                $result .= '<td>' . $page_info["phone3"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">telegram</th>';
                $result .= '<td>' . $page_info["telegram"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">instagram</th>';
                $result .= '<td>' . $page_info["instagram"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">linkedin</th>';
                $result .= '<td>' . $page_info["linkedin"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">whatsapp</th>';
                $result .= '<td>' . $page_info["whatsapp"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">email</th>';
                $result .= '<td>' . $page_info["email"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">location</th>';
                $result .= '<td>' . $page_info["location"] . '</td>';
                $result .= "</tr>";
                foreach (json_decode($page_info["images"]) as $key => $item) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">image' . ($key + 1) . '</th>';
                    $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $item . '" alt=""></td>';
                    $result .= "</tr>";
                    $result .= "<tr>";
                    $result .= '<th scope="row">alt' . ($key + 1) . '</th>';
                    $result .= '<td>' . (json_decode($page_info["alts"]))[$key] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getPageBriefdescription") {
            $page_id = sanitizeInput($_POST['page_id']);
            $page_info = $this->getPage($page_id)[0];
            $result = '';
            echo $page_info['brief_description'];
        }

        if ($act == "getPageDescription") {
            $page_id = sanitizeInput($_POST['page_id']);
            $page_info = $this->getPage($page_id)[0];
            $result = '';
            echo html_entity_decode($page_info['description']);
        }

        if ($act == "pageDelete") {
            $page_id = $option;
            $page_info = $this->getPage($page_id)[0];
            foreach (json_decode($page_info['images']) as $item) {
                destroy_file($item);
            }

            destroy_file($page_info['page_og_image_seo']);

            $this->deletePage($page_id);

            redirect('adminpanel/Page-pageList?success=true');
        }

        if ($act == "pageEdit") {
            $page_id = $option;
            $page_info = $this->getPage($page_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.pages.edit", ['page' => $page_info, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "editPageProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $page_id = sanitizeInput($_POST['page_id']);
                $page_info = $this->getPage($page_id)[0];
                $page_images_f = json_decode($page_info['images']);
                $page_images_f_alts = json_decode($page_info['alts']);

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);


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
//                    if ($this->language == 'en'):
//                        setError('enter captcha value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('مقدار کپچا را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل کلمة تحقیق بشكل صحيح');
//                    endif;
//
//                }

                if ($this->language == 'en'):

                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $h1_title = sanitizeInput($_POST['h1_title']);
                    $keywords = sanitizeInput($_POST['keywords']);
                    $pageUrl = sanitizeInput($_POST['pageUrl']);
                    $pageTitle = sanitizeInput($_POST['pageTitle']);
                    $pageDescription = sanitizeInput($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInput($_POST['pageOgType']);
                else:

                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $h1_title = sanitizeInputNonEn($_POST['h1_title']);
                    $keywords = sanitizeInputNonEn($_POST['keywords']);
                    $pageUrl = sanitizeInputNonEn($_POST['pageUrl']);
                    $pageTitle = sanitizeInputNonEn($_POST['pageTitle']);
                    $pageDescription = sanitizeInputNonEn($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInputNonEn($_POST['pageOgType']);
                endif;

                $location = $_POST['location'];
                $description = $_POST['description'];
                $phone3 = sanitizeInput($_POST['phone3']);
                $phone2 = sanitizeInput($_POST['phone2']);
                $phone1 = sanitizeInput($_POST['phone1']);
                $email = sanitizeInput($_POST['email']);
                $linkedin = sanitizeInput($_POST['linkedin']);
                $whatsapp = sanitizeInput($_POST['whatsapp']);
                $instagram = sanitizeInput($_POST['instagram']);
                $telegram = sanitizeInput($_POST['telegram']);

//                if (strlen($brief_description) <= 10) {
//                    if ($this->language == 'en'):
//                        setError('The minimum length of the brief description is 10 characters.');
//                    elseif ($this->language == 'fa'):
//                        setError('حداقل طول توضیح مختصر 10 کاراکتر میباشد.');
//                    elseif ($this->language == 'ar'):
//                        setError('الحد الأدنى لطول الوصف المختصر هو 10 أحرف.');
//                    endif;
//                }

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

//                if (strlen($h1_title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter h1_title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان H1 را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان H1 بشكل صحيح');
//                    endif;
//                }

                if (strlen($description) <= 20) {
                    if ($this->language == 'en'):
                        setError('The minimum length of the description is 10 characters.');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
                    elseif ($this->language == 'ar'):
                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
                    endif;
                }

                if ($email != "" and !emailVerify($email)) {
                    if ($this->language == 'en'):
                        setError('Enter email correctly');
                    elseif ($this->language == 'fa'):
                        setError('ایمیل را صحیح وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل البريد الإلكتروني الصحيح');
                    endif;
                }

                $images = '';
                $imageOg = '';
                $imageAlts = [];

                foreach ($_POST['pageImageAlts'] as $pageImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($pageImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($pageImageAlt);
                    endif;
                }


                if (empty(getErrors())) {
                    if (!empty($_FILES['pageImages']) and !empty($_FILES['pageImages']['name'])) {
                        $page_images = $_FILES['pageImages'];
                        if (count($_FILES['pageImages']['name']) != count($_POST['pageImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        } else {
                            foreach ($imageAlts as $alt) {
                                $page_images_f_alts[] = $alt;
                            }

                            $imageAlts = json_encode(array_values($page_images_f_alts));
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($page_images, 'page', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($images == '') {
                                if ($this->language == 'en'):
                                    setError('enter image with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('تصویر را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل الصورة بالتنسيق الصحيح');
                                endif;
                            } else {
                                foreach (json_decode($images) as $val) {
                                    $page_images_f[] = $val;
                                }
                            }
                        }
                    }

                    $images = json_encode(array_values($page_images_f));
                    if (!empty($_FILES['pageOgImage']) and $_FILES['pageOgImage']['name'] != '') {
                        $pageOgImage = $_FILES['pageOgImage'];
                        $imageOg = file_upload($pageOgImage, 'page', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageOg == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        }
                    }

                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/page-pageEdit-' . $page_id . '?error=true');
                }


                if (empty(getErrors())) {

                    $v = $this->editPage($page_id, $title, $brief_description, $description, $h1_title, $keywords, $location, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);
                    redirect('adminpanel/Page-pageList?success=true');
                }


            }
        }

        if ($act == "pageDeleteImage") {
            $page_id = sanitizeInput($_POST['page_id']);
            $image_no = sanitizeInput($_POST['image_no']);
            $page_info = $this->getPage($page_id)[0];
            $page_images = json_decode($page_info['images']);
            $page_images_alts = json_decode($page_info['alts']);
            destroy_file($page_images[$image_no - 1]);
            unset($page_images[$image_no - 1]);
            unset($page_images_alts[$image_no - 1]);
            $page_images = json_encode(array_values($page_images));
            $page_images_alts = json_encode(array_values($page_images_alts));
            $this->updatePageImages($page_id, $page_images, $page_images_alts);
            echo true;

        }

        if ($act == "pageIsShow") {
            $page_id = sanitizeInput($_POST['page_id']);
            $situation = sanitizeInput($_POST['situation']);

            $this->updatePageIsShow($page_id, $situation);
            echo true;

        }

    }

    private function registerPage($title, $brief_description, $description, $h1_title, $keywords, $location, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'description' => $description,
            'keywords' => $keywords,
            'h1_title' => $h1_title,
            'alts' => $imageAlts,
            'created_at_jalali' => CalendarUtils::strftime("Y/m/d H:i:s"),
            'created_at' => date("Y/m/d H:i:s"),
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_type_seo' => $pageOgType,
            'language' => $this->language,
            'telegram' => $telegram,
            'instagram' => $instagram,
            'whatsapp' => $whatsapp,
            'linkedin' => $linkedin,
            'email' => $email,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'location' => $location
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->insert("pages", $data);
    }

    public function getPages($language)
    {
        $query = "select * from `pages` where `language`='".$language."' order by `id` desc";

        return $this->db->rawQuery($query);
    }

    public function getPage($page_id)
    {
        $data = [
            'id' => $page_id
        ];

        return $this->db->select_q("pages", $data);
    }

    private function deletePage($page_id)
    {
        $query = "delete from `pages` where `id`='" . $page_id . "'";
        return $this->db->rawQuery($query);
    }

    private function updatePageImages($page_id, $page_images, $page_images_alts)
    {

        $data = [
            'images' => $page_images,
            'alts' => $page_images_alts
        ];

        return $this->db->update("pages", $data, "id = '" . $page_id . "'");

    }

    private function editPage($page_id, $title, $brief_description, $description, $h1_title, $keywords, $location, $phone1, $phone2, $phone3, $email, $linkedin, $whatsapp, $telegram, $instagram, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'description' => $description,
            'keywords' => $keywords,
            'h1_title' => $h1_title,
            'alts' => $imageAlts,
            'created_at_jalali' => CalendarUtils::strftime("Y/m/d H:i:s"),
            'created_at' => date("Y/m/d H:i:s"),
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_type_seo' => $pageOgType,
            'language' => $this->language,
            'telegram' => $telegram,
            'instagram' => $instagram,
            'whatsapp' => $whatsapp,
            'linkedin' => $linkedin,
            'email' => $email,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'phone3' => $phone3,
            'location' => $location
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->update("pages", $data, "id='" . $page_id . "'");
    }

    private function updatePageIsShow($page_id, $situation)
    {
        $data = [
            'is_show' => $situation
        ];

        return $this->db->update("pages", $data, 'id="' . $page_id . '"');
    }

}