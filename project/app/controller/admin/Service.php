<?php

namespace App\controller\admin;

use Carbon\Carbon;
use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
 
class Service
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

    public function act($act, $option = "")
    {

        if ($act == "createServiceCategory") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.service.category_create", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "createServiceCategoryProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
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
                    $pageUrl = sanitizeInput($_POST['pageUrl']);
                    $pageTitle = sanitizeInput($_POST['pageTitle']);
                    $pageDescription = sanitizeInput($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInput($_POST['pageOgType']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $pageUrl = sanitizeInputNonEn($_POST['pageUrl']);
                    $pageTitle = sanitizeInputNonEn($_POST['pageTitle']);
                    $pageDescription = sanitizeInputNonEn($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInputNonEn($_POST['pageOgType']);
                endif;

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

                $image = '';
                $imageOg = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['categoryImage']) and $_FILES['categoryImage']['name'] != '') {
                        $category_image = $_FILES['categoryImage'];
                        $image = file_upload($category_image, 'service_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($image == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        }
                    }

                    if (!empty($_FILES['categoryOgImage']) and $_FILES['categoryOgImage']['name'] != '') {
                        $category_image = $_FILES['categoryOgImage'];
                        $imageOg = file_upload($category_image, 'service_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Service-createServiceCategory?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerServiceCategory($title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
                    redirect('adminpanel/Service-serviceCategoryList');
                }
            }
        }

        if ($act == "serviceCategoryList") {
            $categories = $this->getServiceCategories($this->language);
            renderView("admin.$this->language.service.category_list", ['categories' => $categories]);
        }

        if ($act == "serviceCategoryEdit") {
            $category_id = $option;
            $category = $this->getServiceCategory($category_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.service.category_edit", ['category' => $category, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "serviceCategoryEditProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                $this->language = getLanguage();
                $category_id = sanitizeInput($_POST['category_id']);
                $category = $this->getServiceCategory($category_id)[0];

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
                    $title = sanitizeInput($_POST['title']) ?? $category['title'];
                    $pageUrl = sanitizeInput($_POST['pageUrl']) ?? $category['page_url'];
                    $pageTitle = sanitizeInput($_POST['pageTitle']) ?? $category['page_title_seo'];
                    $pageDescription = sanitizeInput($_POST['pageDescription']) ?? $category['page_description_seo'];
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords']))) ?? $category['page_keywords_seo'];
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']) ?? $category['page_og_title_seo'];
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']) ?? $category['page_og_title_seo'];
                    $pageOgType = sanitizeInput($_POST['pageOgType']) ?? $category['page_og_type_seo'];
                else:
                    $title = sanitizeInputNonEn($_POST['title']) ?? $category['title'];
                    $pageUrl = sanitizeInputNonEn($_POST['pageUrl']) ?? $category['page_url'];
                    $pageTitle = sanitizeInputNonEn($_POST['pageTitle']) ?? $category['page_title_seo'];
                    $pageDescription = sanitizeInputNonEn($_POST['pageDescription']) ?? $category['page_description_seo'];
                    $pageKeywords = implode(',', explode('+', sanitizeInputNonEn($_POST['pageKeywords']))) ?? $category['page_keywords_seo'];
                    $pageOgTitle = sanitizeInputNonEn($_POST['pageOgTitle']) ?? $category['page_og_title_seo'];
                    $pageOgDescription = sanitizeInputNonEn($_POST['pageOgDescription']) ?? $category['page_og_title_seo'];
                    $pageOgType = sanitizeInputNonEn($_POST['pageOgType']) ?? $category['page_og_type_seo'];
                endif;

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

                $image = '';
                $imageOg = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['categoryImage']) and $_FILES['categoryImage']['name'] != '') {
                        $category_image = $_FILES['categoryImage'];
                        $image = file_upload($category_image, 'service_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($image == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($category['category_image']);
                        }
                    }

                    if (!empty($_FILES['categoryOgImage']) and $_FILES['categoryOgImage']['name'] != '') {
                        $category_image = $_FILES['categoryOgImage'];
                        $imageOg = file_upload($category_image, 'service_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageOg == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($category['page_og_image_seo']);
                        }
                    }
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-serviceCategoryEdit-' . $category_id . '?error=true');
                }
                if (empty(getErrors())) {
                    $this->editServiceCategory($category_id, $title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
                    redirect('adminpanel/Service-serviceCategoryList');
                }


            }
        }

        if ($act == "serviceCategoryDelete") {
            $category_id = $option;
            $category = $this->getServiceCategory($category_id)[0];
            destroy_file($category['category_image']);
            destroy_file($category['page_og_image_seo']);

            $this->deleteServiceCategory($category_id);

            redirect('adminpanel/Service-serviceCategoryList');
        }

        if ($act == "getServiceCategorySeoInfo") {
            $category_id = sanitizeInput($_POST['category_id']);
            $service_category_info = $this->getServiceCategory($category_id)[0];
            $result = '';
            if (service_category_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $service_category_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $service_category_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $service_category_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $service_category_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $service_category_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $service_category_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $service_category_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $service_category_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;

        }

        if ($act == "createService") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $categories = $this->getServiceCategories($this->language);

            renderView("admin.$this->language.service.create", ['categories' => $categories, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "createServiceProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('category', $_POST['category']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('h1_title', $_POST['h1_title']);
                newRequest('description', $_POST['description']);
                newRequest('keywords', $_POST['keywords']);
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
                    $category = sanitizeInput($_POST['category']);
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
                    $category = sanitizeInputNonEn($_POST['category']);
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

                $description = $_POST['description'];

                if ($category == "") {
                    if ($this->language == 'en'):
                        setError('choose category value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دسته بندی را به درستی انتخاب کنید');
                    elseif ($this->language == 'ar'):
                        setError('اختر الفئة الصحيحة');
                    endif;

                }

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

                if (strlen($h1_title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter h1_title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان H1 را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان H1 بشكل صحيح');
                    endif;
                }

                if (strlen($description) <= 20) {
                    if ($this->language == 'en'):
                        setError('The minimum length of the description is 10 characters.');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
                    elseif ($this->language == 'ar'):
                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
                    endif;
                }

                $image = '';
                $imageOg = '';

                $imageAlts = [];

                foreach ($_POST['serviceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($serviceImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($serviceImageAlt);
                    endif;
                }

                $imageAlts = json_encode($imageAlts);
                if (empty(getErrors())) {
                    if (!empty($_FILES['serviceImages']) and !empty($_FILES['serviceImages']['name'])) {
                        $service_image = $_FILES['serviceImages'];
                        if (count($_FILES['serviceImages']['name']) != count($_POST['serviceImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($service_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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

                    if (!empty($_FILES['serviceOgImage']) and $_FILES['serviceOgImage']['name'] != '') {
                        $service_image = $_FILES['serviceOgImage'];
                        $imageOg = file_upload($service_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Service-createService?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerService($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);

                    redirect('adminpanel/Service-serviceList?success=true');
                }

            }
        }

        if ($act == "serviceList") {

            $services = $this->getServices();

            renderView("admin.$this->language.service.list", ['services' => $services]);

        }

        if ($act == "getServiceSeoInfo") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getService($service_id)[0];

            $result = '';
            if ($service_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $service_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $service_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $service_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $service_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $service_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $service_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $service_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $service_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getServiceDetails") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getService($service_id)[0];

            $result = '';
            if ($service_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $service_info["keywords"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">h1_title</th>';
                $result .= '<td>' . $service_info["h1_title"] . '</td>';
                $result .= "</tr>";
                foreach (json_decode($service_info["images"]) as $key => $item) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">image' . ($key + 1) . '</th>';
                    $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $item . '" alt=""></td>';
                    $result .= "</tr>";
                    $result .= "<tr>";
                    $result .= '<th scope="row">alt' . ($key + 1) . '</th>';
                    $result .= '<td>' . (json_decode($service_info["alts"]))[$key] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getServiceBriefdescription") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getService($service_id)[0];
            $result = '';
            echo $service_info['brief_description'];
        }

        if ($act == "getServiceDescription") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getService($service_id)[0];
            $result = '';
            echo html_entity_decode($service_info['description']);
        }

        if ($act == "serviceDelete") {
            $service_id = $option;
            $service_info = $this->getService($service_id)[0];
            foreach (json_decode($service_info['images']) as $item) {
                destroy_file($item);
            }

            destroy_file($service_info['page_og_image_seo']);

            $this->deleteService($service_id);

            redirect('adminpanel/Service-serviceList?success=true');
        }

        if ($act == "serviceEdit") {
            $service_id = $option;
            $service_info = $this->getService($service_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $categories = $this->getServiceCategories($this->language);
            renderView("admin.$this->language.service.edit", ['categories' => $categories, 'service' => $service_info, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "editServiceProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $service_id = sanitizeInput($_POST['service_id']);
                $service_info = $this->getService($service_id)[0];
                $service_images_f = json_decode($service_info['images']);
                $service_images_f_alts = json_decode($service_info['alts']);

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('category', $_POST['category']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('h1_title', $_POST['h1_title']);
                newRequest('description', $_POST['description']);
                newRequest('keywords', $_POST['keywords']);
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
                    $category = sanitizeInput($_POST['category']);
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
                    $category = sanitizeInputNonEn($_POST['category']);
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

                $description = $_POST['description'];

                if ($category == "") {
                    if ($this->language == 'en'):
                        setError('choose category value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دسته بندی را به درستی انتخاب کنید');
                    elseif ($this->language == 'ar'):
                        setError('اختر الفئة الصحيحة');
                    endif;

                }

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

                if (strlen($h1_title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter h1_title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان H1 را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان H1 بشكل صحيح');
                    endif;
                }

                if (strlen($description) <= 20) {
                    if ($this->language == 'en'):
                        setError('The minimum length of the description is 10 characters.');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
                    elseif ($this->language == 'ar'):
                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
                    endif;
                }

                $images = '';
                $imageOg = '';
                $imageAlts = [];

                foreach ($_POST['serviceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($serviceImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($serviceImageAlt);
                    endif;
                }


                if (empty(getErrors())) {
                    if (!empty($_FILES['serviceImages']) and !empty($_FILES['serviceImages']['name'])) {
                        $service_images = $_FILES['serviceImages'];
                        if (count($_FILES['serviceImages']['name']) != count($_POST['serviceImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        } else {
                            foreach ($imageAlts as $alt) {
                                $service_images_f_alts[] = $alt;
                            }

                            $imageAlts = json_encode(array_values($service_images_f_alts));
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($service_images, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                                    $service_images_f[] = $val;
                                }
                            }
                        }
                    }

                    $images = json_encode(array_values($service_images_f));
                    if (!empty($_FILES['serviceOgImage']) and $_FILES['serviceOgImage']['name'] != '') {
                        $serviceOgImage = $_FILES['serviceOgImage'];
                        $imageOg = file_upload($serviceOgImage, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Service-serviceEdit-' . $service_id . '?error=true');
                }

                if (empty(getErrors())) {

                    $v = $this->editService($service_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);
                    redirect('adminpanel/Service-serviceList?success=true');
                }


            }
        }

        if ($act == "serviceDeleteImage") {
            $service_id = sanitizeInput($_POST['service_id']);
            $image_no = sanitizeInput($_POST['image_no']);
            $service_info = $this->getService($service_id)[0];
            $service_images = json_decode($service_info['images']);
            $service_images_alts = json_decode($service_info['alts']);
            destroy_file($service_images[$image_no - 1]);
            unset($service_images[$image_no - 1]);
            unset($service_images_alts[$image_no - 1]);
            $service_images = json_encode(array_values($service_images));
            $service_images_alts = json_encode(array_values($service_images_alts));
            $this->updateServiceImages($service_id, $service_images, $service_images_alts);
            echo true;

        }

        if ($act == "serviceIsShow") {
            $service_id = sanitizeInput($_POST['service_id']);
            $situation = sanitizeInput($_POST['situation']);

             echo $this->updateServiceIsShow($service_id, $situation);
//            echo true;

        }

    }

    private function registerServiceCategory($title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
    {
        $data = [
            'title' => $title,
            'language' => $this->language,
            'created_at' => date("Y/m/d H:i:s"),
            'category_image' => $image,
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_image_seo' => $imageOg,
            'page_og_type_seo' => $pageOgType
        ];

        return $this->db->insert('service_category', $data);

    }

    private function getServiceCategories($language)
    {
        $data = [
            'language' => $language
        ];
        return $this->db->select_q("service_category", $data, "order by id desc");
    }

    private function getServiceCategory($category_id)
    {
        $data = [
            'id' => $category_id
        ];

        return $this->db->select_q("service_category", $data);
    }

    private function editServiceCategory($category_id, $title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
    {
        $data = [
            'title' => $title,
            'page_url' => $pageUrl,
            'page_title_seo' => $pageTitle,
            'page_description_seo' => $pageDescription,
            'page_keywords_seo' => $pageKeywords,
            'page_og_title_seo' => $pageOgTitle,
            'page_og_description_seo' => $pageOgDescription,
            'page_og_type_seo' => $pageOgType,
        ];
        if ($image != '') {
            $data['category_image'] = $image;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }
        return $this->db->update('service_category', $data, "id=$category_id");
    }

    private function deleteServiceCategory($category_id)
    {
        return $this->db->rawQuery("delete from `service_category` where `id`=$category_id");
    }

    private function registerService($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
    {
        $data = [
            'category_id' => $category,
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
            'language' => $this->language
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->insert("services", $data);
    }

    private function getServices()
    {
        $query = "select services.*,service_category.id AS CatId,service_category.title AS CatTitle from `services` join `service_category` on service_category.id=services.category_id where services.language='" . $this->language . "' order by services.id desc";
        return $this->db->rawQuery($query);
    }

    private function getService($service_id)
    {
        $data = [
            'id' => $service_id
        ];

        return $this->db->select_q('services', $data);
    }

    private function deleteService($service_id)
    {
        $query = "delete from `services` where `id`='" . $service_id . "'";
        return $this->db->rawQuery($query);
    }

    private function updateServiceImages($service_id, $service_images, $service_images_alts)
    {
        $data = [
            'images' => $service_images,
            'alts' => $service_images_alts
        ];

        return $this->db->update("services", $data, "id = '" . $service_id . "'");
    }

    private function editService($service_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
    {
        $data = [
            'category_id' => $category,
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
            'language' => $this->language
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->update("services", $data, "id='" . $service_id . "'");
    }

    private function updateServiceIsShow($service_id, $situation)
    {
        $data = [
            'is_show' => $situation
        ];

        return $this->db->update("services", $data, 'id="' . $service_id . '"');
    }
}