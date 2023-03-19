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
                newRequest('enTitle', $_POST['enTitle']);
                newRequest('pageUrl', $_POST['pageUrl']);
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

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $enTitle = sanitizeInput($_POST['enTitle']);
                    $pageUrl = sanitizeInput($_POST['pageUrl']);
                    $pageTitle = sanitizeInput($_POST['pageTitle']);
                    $pageDescription = sanitizeInput($_POST['pageDescription']);
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords'])));
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']);
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']);
                    $pageOgType = sanitizeInput($_POST['pageOgType']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $enTitle = sanitizeInputNonEn($_POST['enTitle']);
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
                    $res = $this->registerServiceCategory($title, $enTitle, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
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
                    $enTitle = sanitizeInput($_POST['enTitle']) ?? $category['enTitle'];
                    $pageUrl = sanitizeInput($_POST['pageUrl']) ?? $category['page_url'];
                    $pageTitle = sanitizeInput($_POST['pageTitle']) ?? $category['page_title_seo'];
                    $pageDescription = sanitizeInput($_POST['pageDescription']) ?? $category['page_description_seo'];
                    $pageKeywords = implode(',', explode('+', sanitizeInput($_POST['pageKeywords']))) ?? $category['page_keywords_seo'];
                    $pageOgTitle = sanitizeInput($_POST['pageOgTitle']) ?? $category['page_og_title_seo'];
                    $pageOgDescription = sanitizeInput($_POST['pageOgDescription']) ?? $category['page_og_title_seo'];
                    $pageOgType = sanitizeInput($_POST['pageOgType']) ?? $category['page_og_type_seo'];
                else:
                    $title = sanitizeInputNonEn($_POST['title']) ?? $category['title'];
                    $enTitle = sanitizeInputNonEn($_POST['enTitle']) ?? $category['enTitle'];
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
                    $this->editServiceCategory($category_id, $title, $enTitle, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
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
            if ($service_category_info) {

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
                newRequest('service_guide_title', $_POST['service_guide_title']);
                newRequest('service_guide_brief_description', $_POST['service_guide_brief_description']);
                newRequest('service_part_title', $_POST['service_part_title']);
                newRequest('service_sample_title', $_POST['service_sample_title']);
                newRequest('service_sample_description', $_POST['service_sample_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

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
                    $service_guide_title = sanitizeInput($_POST['service_guide_title']);
                    $service_guide_brief_description = sanitizeInput($_POST['service_guide_brief_description']);
                    $service_part_title = sanitizeInput($_POST['service_part_title']);
                    $service_sample_title = sanitizeInput($_POST['service_sample_title']);
                    $service_sample_description = sanitizeInput($_POST['service_sample_description']);
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
                    $service_guide_title = sanitizeInputNonEn($_POST['service_guide_title']);
                    $service_guide_brief_description = sanitizeInputNonEn($_POST['service_guide_brief_description']);
                    $service_part_title = sanitizeInputNonEn($_POST['service_part_title']);
                    $service_sample_title = sanitizeInputNonEn($_POST['service_sample_title']);
                    $service_sample_description = sanitizeInputNonEn($_POST['service_sample_description']);
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

//                if (strlen($brief_description) <= 10) {
//                    if ($this->language == 'en'):
//                        setError('The minimum length of the brief description is 10 characters.');
//                    elseif ($this->language == 'fa'):
//                        setError('حداقل طول توضیح مختصر 10 کاراکتر میباشد.');
//                    elseif ($this->language == 'ar'):
//                        setError('الحد الأدنى لطول الوصف المختصر هو 10 أحرف.');
//                    endif;
//                }
//
//                if (strlen($title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان بشكل صحيح');
//                    endif;
//                }
//
//                if (strlen($h1_title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter h1_title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان H1 را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان H1 بشكل صحيح');
//                    endif;
//                }
//
//                if (strlen($description) <= 20) {
//                    if ($this->language == 'en'):
//                        setError('The minimum length of the description is 10 characters.');
//                    elseif ($this->language == 'fa'):
//                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
//                    elseif ($this->language == 'ar'):
//                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
//                    endif;
//                }

                $image = '';
                $imageOg = '';
                $indexImage = '';
                $video = '';
                $videoPoster = '';

                $imageAlts = [];

                foreach ($_POST['serviceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = $serviceImageAlt ? sanitizeInput($serviceImageAlt) : $title;
                    else:
                        $imageAlts[] = $serviceImageAlt ? sanitizeInputNonEn($serviceImageAlt) : $title;
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

                    if (!empty($_FILES['indexImage']) and !empty($_FILES['indexImage']['name'])) {
                        $indexImagee = $_FILES['indexImage'];

                        if (empty(getErrors())) {
                            $indexImage = file_upload($indexImagee, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($indexImage == '') {
                                if ($this->language == 'en'):
                                    setError('enter small index image with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('تصویر شاخص کوچک را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل صورة فهرس صغيرة بالتنسيق الصحيح');
                                endif;
                            } else {
                                $indexImageALt = $_POST['indexImageAlt'] ? sanitizeInputNonEn($_POST['indexImageAlt']) : $title;
                            }
                        }
                    }

                    if (!empty($_FILES['videoPoster']) and !empty($_FILES['videoPoster']['name'])) {
                        $videoPosterr = $_FILES['videoPoster'];

                        if (empty(getErrors())) {
                            $videoPoster = file_upload($videoPosterr, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($videoPoster == '') {
                                if ($this->language == 'en'):
                                    setError('enter video poster with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('پوستر ویدئو را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل ملصق فيديو بالتنسيق الصحيح');
                                endif;
                            }
                        }
                    }


                    if (!empty($_FILES['video']) and !empty($_FILES['video']['name'])) {
                        $videoo = $_FILES['video'];

                        if (empty(getErrors())) {
                            $video = file_upload($videoo, 'service', ['mp4']);
                            if ($video == '') {
                                if ($this->language == 'en'):
                                    setError('enter video with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('ویدئو را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل فیدئو بالتنسيق الصحيح');
                                endif;
                            }
                        }
                    } elseif ($_POST['videoLink']) {
                        $video = $_POST['videoLink'];
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
                    $v = $this->registerService($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $service_guide_title, $service_guide_brief_description, $service_part_title, $service_sample_title, $service_sample_description, $indexImage, $indexImageALt, $video, $videoPoster);

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

                $result .= "<tr>";
                $result .= '<th scope="row">index_image</th>';
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $service_info['index_image'] . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">index_image_alt</th>';
                $result .= '<td>' . $service_info["index_image_alt"] . '</td>';
                $result .= "</tr>";

                $result .= "<tr>";
                $result .= '<th scope="row">video</th>';
                $result .= '<td> <video width="80" height="50" controls><source src="' . baseUrl(httpCheck()) . $service_info['video'] . '" type="video/mp4"></video></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">video poster</th>';
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $service_info['video_poster'] . '" alt=""></td>';
                $result .= "</tr>";

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
                    $service_guide_title = sanitizeInput($_POST['service_guide_title']);
                    $service_guide_brief_description = sanitizeInput($_POST['service_guide_brief_description']);
                    $service_part_title = sanitizeInput($_POST['service_part_title']);
                    $service_sample_title = sanitizeInput($_POST['service_sample_title']);
                    $service_sample_description = sanitizeInput($_POST['service_sample_description']);
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
                    $service_guide_title = sanitizeInputNonEn($_POST['service_guide_title']);
                    $service_guide_brief_description = sanitizeInputNonEn($_POST['service_guide_brief_description']);
                    $service_part_title = sanitizeInputNonEn($_POST['service_part_title']);
                    $service_sample_title = sanitizeInputNonEn($_POST['service_sample_title']);
                    $service_sample_description = sanitizeInputNonEn($_POST['service_sample_description']);
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

//                if (strlen($brief_description) <= 10) {
//                    if ($this->language == 'en'):
//                        setError('The minimum length of the brief description is 10 characters.');
//                    elseif ($this->language == 'fa'):
//                        setError('حداقل طول توضیح مختصر 10 کاراکتر میباشد.');
//                    elseif ($this->language == 'ar'):
//                        setError('الحد الأدنى لطول الوصف المختصر هو 10 أحرف.');
//                    endif;
//                }
//
//                if (strlen($title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان بشكل صحيح');
//                    endif;
//                }
//
//                if (strlen($h1_title) <= 2) {
//                    if ($this->language == 'en'):
//                        setError('enter h1_title value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('عنوان H1 را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل العنوان H1 بشكل صحيح');
//                    endif;
//                }
//
//                if (strlen($description) <= 20) {
//                    if ($this->language == 'en'):
//                        setError('The minimum length of the description is 10 characters.');
//                    elseif ($this->language == 'fa'):
//                        setError('حداقل طول توضیح  20 کاراکتر میباشد.');
//                    elseif ($this->language == 'ar'):
//                        setError('الحد الأدنى لطول الوصف المختصر هو 20 أحرف.');
//                    endif;
//                }

                $images = '';
                $imageOg = '';
                $indexImage = '';
                $video = '';
                $videoPoster = '';
                $imageAlts = [];

                foreach ($_POST['serviceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = $serviceImageAlt ? sanitizeInput($serviceImageAlt) : $title;
                    else:
                        $imageAlts[] = $serviceImageAlt ? sanitizeInputNonEn($serviceImageAlt) : $title;
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


                    if (!empty($_FILES['indexImage']) and !empty($_FILES['indexImage']['name'])) {
                        $indexImagee = $_FILES['indexImage'];

                        if (empty(getErrors())) {
                            $indexImage = file_upload($indexImagee, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($images == '') {
                                if ($this->language == 'en'):
                                    setError('enter small index image with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('تصویر شاخص کوچک را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل صورة فهرس صغيرة بالتنسيق الصحيح');
                                endif;
                            } else {
                                destroy_file($service_info['index_image']);
                                $indexImageALt = $_POST['indexImageAlt'] ? sanitizeInputNonEn($_POST['indexImageAlt']) : $title;
                            }
                        }
                    }

                    if (!empty($_FILES['videoPoster']) and !empty($_FILES['videoPoster']['name'])) {
                        $videoPosterr = $_FILES['videoPoster'];

                        if (empty(getErrors())) {
                            $videoPoster = file_upload($videoPosterr, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($videoPoster == '') {
                                if ($this->language == 'en'):
                                    setError('enter video poster with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('پوستر ویدئو را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل ملصق فيديو بالتنسيق الصحيح');
                                endif;
                            }
                        }
                    }


                    if (!empty($_FILES['video']) and !empty($_FILES['video']['name'])) {
                        $videoo = $_FILES['video'];

                        if (empty(getErrors())) {
                            $video = file_upload($videoo, 'service', ['mp4']);
                            if ($video == '') {
                                if ($this->language == 'en'):
                                    setError('enter video with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('ویدئو را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل فیدئو بالتنسيق الصحيح');
                                endif;
                            }
                        }
                    } elseif ($_POST['videoLink']) {
                        $video = $_POST['videoLink'];

                    }


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


                    $v = $this->editService($service_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $service_guide_title, $service_guide_brief_description, $service_part_title, $service_sample_title, $service_sample_description, $indexImage, $indexImageALt, $video, $videoPoster);
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

        if ($act == "serviceIsVideoShow") {
            $service_id = sanitizeInput($_POST['service_id']);
            $situation = sanitizeInput($_POST['situation']);

            echo $this->updateServiceIsVideoShow($service_id, $situation);
//            echo true;

        }

        if ($act == "serviceIsComing") {
            $service_id = sanitizeInput($_POST['service_id']);
            $situation = sanitizeInput($_POST['situation']);

            echo $this->updateServiceIsComing($service_id, $situation);
//            echo true;

        }

        if ($act == "createSampleService") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $services = $this->getServices();

            renderView("admin.$this->language.service.sample_create", ['services' => $services, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "createSampleServiceProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('service', $_POST['service']);
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


                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
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
                    $service = sanitizeInputNonEn($_POST['service']);
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

                if ($service == "") {
                    if ($this->language == 'en'):
                        setError('choose service value correctly');
                    elseif ($this->language == 'fa'):
                        setError('سرویس را به درستی انتخاب کنید');
                    elseif ($this->language == 'ar'):
                        setError('اختر السرویس الصحيحة');
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
                $imageSmall = '';
                $imageOg = '';

                $imageAlts = [];

                foreach ($_POST['sampleServiceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($serviceImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($serviceImageAlt);
                    endif;
                }

                $imageAlts = json_encode(array_filter($imageAlts));
                if (empty(getErrors())) {
                    if (!empty($_FILES['sampleServiceImages']) and !empty($_FILES['sampleServiceImages']['name'])) {
                        $sample_service_image = $_FILES['sampleServiceImages'];
                        if (count($_FILES['sampleServiceImages']['name']) != count($_POST['sampleServiceImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($sample_service_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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


                    if (!empty($_FILES['sampleServiceImageSmall']) and !empty($_FILES['sampleServiceImageSmall']['name'])) {
                        $sampleServiceImageSmall = $_FILES['sampleServiceImageSmall'];

                        $imageSmall = file_upload($sampleServiceImageSmall, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageSmall == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر کوچک را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        }

                    }


                    if (!empty($_FILES['sampleServiceOgImage']) and $_FILES['sampleServiceOgImage']['name'] != '') {
                        $sample_service_og_image = $_FILES['sampleServiceOgImage'];
                        $imageOg = file_upload($sample_service_og_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Service-createSampleService?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerSampleService($service, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $imageSmall);

                    redirect('adminpanel/Service-sampleServiceList?success=true');
                }

            }
        }

        if ($act == "sampleServiceList") {

            $services = $this->getSampleServices();

            renderView("admin.$this->language.service.sampleServiceList", ['services' => $services]);

        }

        if ($act == "getSampleServiceSeoInfo") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getSampleService($service_id)[0];

            $service_info1 = $this->getService($service_info['service_id'])[0];

            $result = '';
            if ($service_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $service_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url copy</th>';
                $result .= '<td> <button class="btn btn-info btn-sm  copyToClipboard">کپی</button><input type="hidden" id="clipboardSib" class="clipboardSib" value="' . baseUrl(httpCheck()) . $service_info1['page_url'] . '/' . $service_info["page_url"] . '"></td>';
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

        if ($act == "getSampleServiceDetails") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getSampleService($service_id)[0];

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

                $result .= "<tr>";
                $result .= '<th scope="row">تصویر کوچک</th>';
                $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $service_info['image_small'] . '" alt=""></td>';
                $result .= "</tr>";

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getSampleServiceBriefdescription") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getSampleService($service_id)[0];
            $result = '';
            echo $service_info['brief_description'];
        }

        if ($act == "getSampleServiceDescription") {
            $service_id = sanitizeInput($_POST['service_id']);
            $service_info = $this->getSampleService($service_id)[0];
            $result = '';
            echo html_entity_decode($service_info['description']);
        }

        if ($act == "sampleServiceDelete") {
            $service_id = $option;
            $service_info = $this->getSampleService($service_id)[0];
            foreach (json_decode($service_info['images']) as $item) {
                destroy_file($item);
            }

            destroy_file($service_info['page_og_image_seo']);

            $this->deleteSampleService($service_id);

            redirect('adminpanel/Service-sampleServiceList?success=true');
        }

        if ($act == "sampleServiceEdit") {
            $service_id = $option;
            $service_info = $this->getSampleService($service_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $services = $this->getServices();
            renderView("admin.$this->language.service.sample_edit", ['services' => $services, 'service' => $service_info, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "editSampleServiceProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $service_id = sanitizeInput($_POST['service_id']);
                $service_info = $this->getSampleService($service_id)[0];
                $service_images_f = json_decode($service_info['images']);
                $service_images_f_alts = json_decode($service_info['alts']);

//                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('service', $_POST['service']);
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

//                if ($checkCsrf === false) {
//
//                    if ($this->language == 'en'):
//                        setError('send information correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('اطلاعات را به درستی ارسال کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('إرسال المعلومات بشكل صحيح');
//                    endif;
//                }


                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
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
                    $service = sanitizeInputNonEn($_POST['service']);
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
                $imageSmall = '';
                $imageOg = '';
                $imageAlts = [];

                foreach ($_POST['sampleServiceImageAlts'] as $serviceImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($serviceImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($serviceImageAlt);
                    endif;
                }


                if (empty(getErrors())) {
                    if (!empty($_FILES['sampleServiceImages']) and !empty($_FILES['sampleServiceImages']['name'])) {
                        $service_images = $_FILES['sampleServiceImages'];
                        if (count($_FILES['sampleServiceImages']['name']) != count($imageAlts)) {
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

                            $imageAlts = json_encode(array_filter(array_values($service_images_f_alts)));
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

                    if (!empty($_FILES['sampleServiceImageSmall']) and !empty($_FILES['sampleServiceImageSmall']['name'])) {
                        $sampleServiceImageSmall = $_FILES['sampleServiceImageSmall'];

                        $imageSmall = file_upload($sampleServiceImageSmall, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imageSmall == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($service_info['image_small']);
                        }

                    }


                    $images = json_encode(array_filter(array_values($service_images_f)));
                    if (!empty($_FILES['sampleServiceOgImage']) and $_FILES['sampleServiceOgImage']['name'] != '') {
                        $serviceOgImage = $_FILES['sampleServiceOgImage'];
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
                    redirect('adminpanel/Service-sampleServiceEdit-' . $service_id . '?error=true');
                }

                if (empty(getErrors())) {

                    $v = $this->editSampleService($service_id, $service, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $imageSmall);
                    redirect('adminpanel/Service-sampleServiceList?success=true');
                }


            }
        }

        if ($act == "sampleServiceDeleteImage") {
            $service_id = sanitizeInput($_POST['service_id']);
            $image_no = sanitizeInput($_POST['image_no']);
            $service_info = $this->getSampleService($service_id)[0];
            $service_images = json_decode($service_info['images']);
            $service_images_alts = json_decode($service_info['alts']);
            destroy_file($service_images[$image_no - 1]);
            unset($service_images[$image_no - 1]);
            unset($service_images_alts[$image_no - 1]);
            $service_images = json_encode(array_values($service_images));
            $service_images_alts = json_encode(array_values($service_images_alts));
            $this->updateSampleServiceImages($service_id, $service_images, $service_images_alts);
            echo true;

        }

        if ($act == "sampleServiceIsShow") {
            $service_id = sanitizeInput($_POST['service_id']);
            $situation = sanitizeInput($_POST['situation']);

            echo $this->updateSampleServiceIsShow($service_id, $situation);
//            echo true;

        }

        if ($act == "createGuide") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $services = $this->getServices();
            renderView("admin.$this->language.service.guide_create", ['token' => $token, 'services' => $services]);
        }

        if ($act == "createGuideProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('service', $_POST['service']);
                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }
                $guideImageAlt = '';
                $icon = '';
                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $guideImageAlt = sanitizeInput($_POST['guideImageAlt']);
                    $icon = sanitizeInput($_POST['icon']);
                else:
                    $service = sanitizeInputNonEn($_POST['service']);
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $guideImageAlt = sanitizeInputNonEn($_POST['guideImageAlt']);
                    $icon = sanitizeInputNonEn($_POST['icon']);
                endif;

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

                $image = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['guideImage']) and !empty($_FILES['guideImage']['name'])) {
                        $guide_image = $_FILES['guideImage'];

                        $image = file_upload($guide_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);

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
                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-createGuide?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerGuideService($service, $title, $brief_description, $guideImageAlt, $image, $icon);

                    redirect('adminpanel/Service-guideServiceList?success=true');
                }

            }
        }

        if ($act == "guideServiceList") {
            $guideServices = $this->getGuideServices();
            renderView("admin.$this->language.service.guideServiceList", ['guideServices' => $guideServices]);
        }

        if ($act == "editGuideService") {
            $guide_id = $option;
            $guideService_info = $this->getGuideService($guide_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $services = $this->getServices();
            renderView("admin.$this->language.service.guide_edit", ['services' => $services, 'guideService_info' => $guideService_info, 'token' => $token]);
        }

        if ($act == "editGuideServiceProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $guide_id = sanitizeInput($_POST['guide_id']);
                $guide_info = $this->getGuideService($guide_id)[0];

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
                $guideImageAlt = '';
                $icon = '';
                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $guideImageAlt = sanitizeInput($_POST['guideImageAlt']);
                    $icon = sanitizeInput($_POST['icon']);
                else:
                    $service = sanitizeInputNonEn($_POST['service']);
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $guideImageAlt = sanitizeInputNonEn($_POST['guideImageAlt']);
                    $icon = sanitizeInputNonEn($_POST['icon']);
                endif;

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

                $image = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['guideImage']) and !empty($_FILES['guideImage']['name'])) {
                        $guide_image = $_FILES['guideImage'];

                        $image = file_upload($guide_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);

                        if ($image == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($guide_info['image']);
                        }

                    }
                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-editGuideService-' . $guide_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->updateGuideService($guide_id, $service, $title, $brief_description, $guideImageAlt, $image, $icon);

                    redirect('adminpanel/Service-guideServiceList?success=true');
                }


            }
        }

        if ($act == "guideServiceDelete") {
            $guide_id = $option;
            $guide_info = $this->getGuideService($guide_id)[0];

            destroy_file($guide_info['image']);

            $this->deleteGuideService($guide_id);

            redirect('adminpanel/Service-guideServiceList?success=true');
        }

        if ($act == "createServicePart") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $services = $this->getServices();
            renderView("admin.$this->language.service.service_part_create", ['token' => $token, "services" => $services]);

        }

        if ($act == "createServicePartProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('service', $_POST['service']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $servicePartImageAlt = sanitizeInput($_POST['servicePartImageAlt']);

                else:
                    $service = sanitizeInputNonEn($_POST['service']);
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $servicePartImageAlt = sanitizeInputNonEn($_POST['servicePartImageAlt']);

                endif;

                if ($service == "") {
                    if ($this->language == 'en'):
                        setError('choose سرویس value correctly');
                    elseif ($this->language == 'fa'):
                        setError('سرویس را به درستی انتخاب کنید');
                    elseif ($this->language == 'ar'):
                        setError('اختر الخدمه الصحيحة');
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


                $image = '';
                $video = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['servicePartImage']) and !empty($_FILES['servicePartImage']['name'])) {
                        $service_part_image = $_FILES['servicePartImage'];

                        if (empty(getErrors())) {
                            $image = file_upload($service_part_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    }

                    if (!empty($_FILES['servicePartVideo']) and $_FILES['servicePartVideo']['name'] != '') {
                        $servicePartVideo = $_FILES['servicePartVideo'];
                        $video = file_upload($servicePartVideo, 'service', ['mp4']);
                        if ($video == '') {
                            if ($this->language == 'en'):
                                setError('enter video with correct format');
                            elseif ($this->language == 'fa'):
                                setError('ویدئو را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الویدئو بالتنسيق الصحيح');
                            endif;
                        }
                    }

                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-createServicePart?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerServicePart($service, $title, $brief_description, $servicePartImageAlt, $image, $video);

                    redirect('adminpanel/Service-ServicePartList?success=true');
                }


            }
        }

        if ($act == "ServicePartList") {
            $serviceParts = $this->getAllServiceParts();
            renderView("admin.$this->language.service.service_part_list", ['token' => $token, "serviceParts" => $serviceParts]);

        }

        if ($act == "servicePartDelete") {
            $service_part_id = $option;
            $service_part_info = $this->getServicePart($service_part_id)[0];
            destroy_file($service_part_info['image']);
            destroy_file($service_part_info['video']);


            $this->deleteServicePart($service_part_id);

            redirect('adminpanel/Service-ServicePartList?success=true');
        }

        if ($act == "editServicePart") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $servicePart_id = $option;
            $services = $this->getServices();
            $servicePartInfo = $this->getServicePart($servicePart_id)[0];

            renderView("admin.$this->language.service.service_part_edit", ['services' => $services, 'token' => $token, "servicePartInfo" => $servicePartInfo]);

        }

        if ($act == "editServicePartProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $servicePart_id = sanitizeInput($_POST['servicePart_id']);
                $servicePartInfo = $this->getServicePart($servicePart_id)[0];
                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('service', $_POST['service']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $service = sanitizeInput($_POST['service']);
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $servicePartImageAlt = sanitizeInput($_POST['servicePartImageAlt']);

                else:
                    $service = sanitizeInputNonEn($_POST['service']);
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $servicePartImageAlt = sanitizeInputNonEn($_POST['servicePartImageAlt']);

                endif;

                if ($service == "") {
                    if ($this->language == 'en'):
                        setError('choose سرویس value correctly');
                    elseif ($this->language == 'fa'):
                        setError('سرویس را به درستی انتخاب کنید');
                    elseif ($this->language == 'ar'):
                        setError('اختر الخدمه الصحيحة');
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


                $image = '';
                $video = '';

                if (empty(getErrors())) {
                    if (!empty($_FILES['servicePartImage']) and !empty($_FILES['servicePartImage']['name'])) {
                        $service_part_image = $_FILES['servicePartImage'];

                        if (empty(getErrors())) {
                            $image = file_upload($service_part_image, 'service', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                            if ($image == '') {
                                if ($this->language == 'en'):
                                    setError('enter image with correct format');
                                elseif ($this->language == 'fa'):
                                    setError('تصویر را با فرمت صحیح وارد کنید');
                                elseif ($this->language == 'ar'):
                                    setError('أدخل الصورة بالتنسيق الصحيح');
                                endif;
                            } else {
                                destroy_file($servicePartInfo['image']);
                            }
                        }
                    }

                    if (!empty($_FILES['servicePartVideo']) and $_FILES['servicePartVideo']['name'] != '') {
                        $servicePartVideo = $_FILES['servicePartVideo'];
                        $video = file_upload($servicePartVideo, 'service', ['mp4']);
                        if ($video == '') {
                            if ($this->language == 'en'):
                                setError('enter video with correct format');
                            elseif ($this->language == 'fa'):
                                setError('ویدئو را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الویدئو بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($servicePartInfo['video']);
                        }
                    }

                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-editServicePart-' . $servicePart_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->editServicePart($servicePart_id, $service, $title, $brief_description, $servicePartImageAlt, $image, $video);

                    redirect('adminpanel/Service-ServicePartList?success=true');
                }


            }
        }

        if ($act == "createServicePageTitles") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $services = $this->getServices();
            renderView("admin.$this->language.service.service_page_title_create", ['token' => $token, "services" => $services]);

        }

        if ($act == "createServicePageTitlesProcess") {

        }

        if ($act == "createKhadamatSubject") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            renderView("admin.$this->language.service.khadamat_subject_create", ['token' => $token]);
        }

        if ($act == "createKhadamatSubjectProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('title_main', $_POST['title_main']);
                newRequest('main_brief_description', $_POST['main_brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title_main = sanitizeInput($_POST['title_main']);
                    $main_brief_description = sanitizeInput($_POST['main_brief_description']);
                else:
                    $title_main = sanitizeInputNonEn($_POST['title_main']);
                    $main_brief_description = sanitizeInputNonEn($_POST['main_brief_description']);
                endif;

                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-createKhadamatSubject?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerKhadamatSubject($title_main, $main_brief_description);
                    redirect('adminpanel/Service-khadamatSubjectList');
                }
            }
        }

        if ($act == "khadamatSubjectList") {
            $khadamatSubjects = $this->getkhadamatSubjects();

            renderView("admin.$this->language.service.khadamat_subject_list", ['khadamatSubjects' => $khadamatSubjects]);

        }

        if ($act == "khadamatSubjectDelete") {
            $khadamatSubject_id = $option;
            $this->deleteKhadamatSubject($khadamatSubject_id);
            redirect('adminpanel/Service-khadamatSubjectList');
        }

        if ($act == "editKhadamatSubject") {
            $khadamatSubject_id = $option;
            $khadamatSubject = $this->getKhadamatSubject($khadamatSubject_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            renderView("admin.$this->language.service.khadamat_subject_edit", ['token' => $token, 'khadamatSubject' => $khadamatSubject]);


        }

        if ($act == "editKhadamatSubjectProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('title_main', $_POST['title_main']);
                newRequest('main_brief_description', $_POST['main_brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title_main = sanitizeInput($_POST['title_main']);
                    $main_brief_description = sanitizeInput($_POST['main_brief_description']);
                else:
                    $title_main = sanitizeInputNonEn($_POST['title_main']);
                    $main_brief_description = sanitizeInputNonEn($_POST['main_brief_description']);
                endif;

                $khadamat_subject_id = sanitizeInput($_POST['khadamt_subject_id']);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-editKhadamatSubject-' . $khadamat_subject_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editKhadamatSubject($khadamat_subject_id, $title_main, $main_brief_description);
                    redirect('adminpanel/Service-khadamatSubjectList');
                }
            }

        }

        if ($act == "createKhadamat") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $khadamat_subject_id=$option;
            renderView("admin.$this->language.service.khadamat_create", ['token' => $token,"khadamat_subject_id"=>$khadamat_subject_id]);
        }

        if ($act == "createKhadamatProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('link', $_POST['link']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('icon', $_POST['icon']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $link = sanitizeInput($_POST['link']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $icon = sanitizeInput($_POST['icon']);

                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $link = sanitizeInputNonEn($_POST['link']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $icon = sanitizeInputNonEn($_POST['icon']);


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

//                $planable_type = [];
//                foreach ($pagee as $item) {
//                    if ($item == 1) {
//                        $planable_type[] = "blog";
//                    } elseif ($item == 2) {
//                        $planable_type[] = "service";
//                    } elseif ($item == 3) {
//                        $planable_type[] = "service_sample";
//                    } elseif ($item == 4) {
//                        $planable_type[] = "news";
//                    } elseif ($item == 5) {
//                        $planable_type[] = "page";
//                    } elseif ($item == 6) {
//                        $planable_type[] = "index";
//                    } elseif ($item == 7) {
//                        $planable_type[] = "services";
//                    } elseif ($item == 8) {
//                        $planable_type[] = "blogs";
//                    } elseif ($item == 9) {
//                        $planable_type[] = "news";
//                    } elseif ($item == 10) {
//                        $planable_type[] = "sampleServices";
//                    }
//                }
//                $planable_type = json_encode($planable_type);
//
//                $planable_id = json_encode($page_children);

                $khadamat_subject_id=sanitizeInput($_POST['khadamat_subject_id']);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-createKhadamat-'.$khadamat_subject_id.'?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerKhadamat($title, $link, $brief_description, $icon,$khadamat_subject_id);
                    redirect('adminpanel/Service-khadamatList-'.$khadamat_subject_id);
                }
            }
        }

        if ($act == "khadamatList") {
            $khadamat_subject_id=$option;
            $khadamats = $this->getKhadamats($khadamat_subject_id);
            $khadamatSubject = $this->getKhadamatSubject($khadamat_subject_id)[0];
            renderView("admin.$this->language.service.khadamat_list", ['token' => $token, "khadamats" => $khadamats, "khadamatSubject" => $khadamatSubject]);
        }

        if ($act == "editKhadamat") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            $khadamat_id = $option;
            $khadamat = $this->getKhadamat($khadamat_id)[0];

            renderView("admin.$this->language.service.khadamat_edit", ['token' => $token, 'khadamat' => $khadamat]);
        }

        if ($act == "editKhadamatProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('link', $_POST['link']);
                newRequest('brief_description', $_POST['brief_description']);
                newRequest('icon', $_POST['icon']);


                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }


                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $link = sanitizeInput($_POST['link']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $icon = sanitizeInput($_POST['icon']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $link = sanitizeInputNonEn($_POST['link']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $icon = sanitizeInputNonEn($_POST['icon']);

                endif;

                $khadamat_id = sanitizeInput($_POST['khadamat_id']);
                $khadamat_subject_id = sanitizeInput($_POST['khadamat_subject_id']);
                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Service-editKhadamat-' . $khadamat_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editKhadamat($khadamat_id, $title, $link, $brief_description, $icon);
                    redirect('adminpanel/Service-khadamatList-'.$khadamat_subject_id);
                }
            }
        }

        if ($act == "khadamatDelete") {
            $khadamat_id = $option;
            $this->deleteKhadamat($khadamat_id);
            redirect('adminpanel/Service-khadamatList');
        }

        if ($act == "getKhadamatsByTitle") {
            $title = sanitizeInputNonEn($_POST['title']);
            $khadamats = $this->getKhadamatsByTitle($title);
            $result = '';

            if ($khadamats) {
                foreach ($khadamats as $key => $khadamat) {

                    $result .= "<tr>";
                    $result .= '<td>' . ($key + 1) . '</td>';
                    $result .= '<td>' . $khadamat["main_title"] . '</td>';
                    $result .= '<td>' . $khadamat["main_brief_description"] . '</td>';
                    $result .= '<td>' . $khadamat["title"] . '</td>';
                    $result .= '<td>' . $khadamat["brief_description"] . '</td>';
                    $result .= '<td>' . $khadamat["icon"] . '</td>';
                    $result .= '<td>' . $khadamat["link"] . '</td>';
                    $result .= '<td>';
                    foreach (json_decode($khadamat['pageable_type']) as $j => $pageable_type) {

                        $result .= ($j + 1) . "-" . match ($pageable_type) {
                                "blog" => "وبلاگ",
                                "service" => "سرویس",
                                "service_sample" => "نمونه سرویس",
                                "news" => "اخبار",
                                "page" => "صفحات",
                                "index" => "صفحه اصلی",
                                "services" => "صفحه سرویس ها",
                                "blogs" => "صفحه وبلاگ ها",
                                "newss" => "صفحه خبر ها",
                                "sampleServices" => "صفحه نمونه سرویس ها"
                            } . "<br>";
                    }
                    $result .= '</td>';
                    $result .= '<td>';
                    foreach (json_decode($khadamat['pageable_id']) as $k => $pageable_idd) {
                        $pageable_id = explode("*", $pageable_idd)[0];
                        $pageable_type_id = explode("*", $pageable_idd)[1];
                        if ($pageable_type_id == 1) {
                            $pageable_type = "blog";
                        } elseif ($pageable_type_id == 2) {
                            $pageable_type = "service";
                        } elseif ($pageable_type_id == 3) {
                            $pageable_type = "service_sample";
                        } elseif ($pageable_type_id == 4) {
                            $pageable_type = "news";
                        } elseif ($pageable_type_id == 5) {
                            $pageable_type = "page";
                        } elseif ($pageable_type_id == 6) {
                            $pageable_type = "index";
                        } elseif ($pageable_type_id == 7) {
                            $pageable_type = "services";
                        } elseif ($pageable_type_id == 8) {
                            $pageable_type = "blogs";
                        } elseif ($pageable_type_id == 9) {
                            $pageable_type = "newss";
                        } elseif ($pageable_type_id == 10) {
                            $pageable_type = "sampleServices";
                        }


                        if ($pageable_type == "blog") {
                            $blog = new \App\controller\admin\Blog();
                            $result .= ($k + 1) . "-" . ($blog->getBlog($pageable_id))[0]['title'] . "<br>";
                        } elseif ($pageable_type == "service") {
                            $service = new \App\controller\admin\Service();
                            $result .= ($k + 1) . "-" . ($service->getService($pageable_id))[0]['title'] . "<br>";
                        } elseif ($pageable_type == "service_sample") {
                            $service = new \App\controller\admin\Service();
                            $result .= ($k + 1) . "-" . ($service->getSampleService($pageable_id))[0]['title'] . "<br>";
                        } elseif ($pageable_type == "news") {
                            $news = new \App\controller\admin\News();
                            $result .= ($k + 1) . "-" . ($news->getSingleNews($pageable_id))[0]['title'] . "<br>";
                        } elseif ($pageable_type == "page") {
                            $page = new \App\controller\admin\Page();
                            $result .= ($k + 1) . "-" . ($page->getPage($pageable_id))[0]['title'] . "<br>";
                        } elseif ($pageable_type == "index") {
                            $result .= ($k + 1) . "-صفحه اصلی<br>";
                        } elseif ($pageable_type == "services") {
                            $result .= ($k + 1) . "-صفحه سرویس ها<br>";
                        } elseif ($pageable_type == "blogs") {
                            $result .= ($k + 1) . "-صفحه وبلاگ ها<br>";
                        } elseif ($pageable_type == "newss") {
                            $result .= ($k + 1) . "-صفحه خبر ها<br>";
                        } elseif ($pageable_type == "sampleServices") {
                            $result .= ($k + 1) . "-صفحه نمونه سرویس ها<br>";
                        }
                    }

                    $result .= '</td>';
                    $result .= "</tr>";

                }
            }

            echo $result;
        }

    }

    private function registerServiceCategory($title, $enTitle, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
    {
        $data = [
            'title' => $title,
            'enTitle' => $enTitle,
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

    public function getServiceCategories($language)
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

    private function editServiceCategory($category_id, $title, $enTitle, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
    {
        $data = [
            'title' => $title,
            'enTitle' => $enTitle,
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

    private function registerService($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $service_guide_title, $service_guide_brief_description, $service_part_title, $service_sample_title, $service_sample_description, $indexImage, $indexImageALt, $video, $videoPoster)
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
            'language' => $this->language,
            'service_guide_title' => $service_guide_title,
            'service_guide_brief_description' => $service_guide_brief_description,
            'service_part_title' => $service_part_title,
            'service_sample_title' => $service_sample_title,
            'service_sample_description' => $service_sample_description
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($indexImage != '') {
            $data['index_image'] = $indexImage;
            $data['index_image_alt'] = $indexImageALt;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }
        if ($video != '') {
            $data['video'] = $video;
        }
        if ($videoPoster != '') {
            $data['video_poster'] = $videoPoster;
        }

        return $this->db->insert("services", $data);
    }

    private function getServices()
    {
        $query = "select services.*,service_category.id AS CatId,service_category.title AS CatTitle from `services` join `service_category` on service_category.id=services.category_id where services.language='" . $this->language . "' order by services.id desc";
        return $this->db->rawQuery($query);
    }

    public function getService($service_id)
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

    private function editService($service_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $service_guide_title, $service_guide_brief_description, $service_part_title, $service_sample_title, $service_sample_description, $indexImage, $indexImageALt, $video, $videoPoster)
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
            'language' => $this->language,
            'service_guide_title' => $service_guide_title,
            'service_guide_brief_description' => $service_guide_brief_description,
            'service_part_title' => $service_part_title,
            'service_sample_title' => $service_sample_title,
            'service_sample_description' => $service_sample_description
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        if ($indexImage != '') {
            $data['index_image'] = $indexImage;
            $data['index_image_alt'] = $indexImageALt;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }
        if ($video != '') {
            $data['video'] = $video;
        }
        if ($videoPoster != '') {
            $data['video_poster'] = $videoPoster;
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

    private function registerSampleService($service, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $imageSamll)
    {

        $data = [
            'service_id' => $service,
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
        if ($imageSamll != '') {
            $data['image_small'] = $imageSamll;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }


        return $this->db->insert("sample_service", $data);
    }

    private function getSampleServices()
    {
        $query = "select sample_service.*,services.id AS SerId,services.title AS SerTitle from `sample_service` join `services` on services.id=sample_service.service_id where sample_service.language='" . $this->language . "' order by sample_service.id desc";
        return $this->db->rawQuery($query);
    }

    public function getSampleService($service_id)
    {
        $data = [
            'id' => $service_id
        ];

        return $this->db->select_q('sample_service', $data);
    }

    private function deleteSampleService($service_id)
    {
        $query = "delete from `sample_service` where `id`='" . $service_id . "'";
        return $this->db->rawQuery($query);
    }

    private function editSampleService($service_id, $service, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg, $imageSmall)
    {

        $data = [
            'service_id' => $service,
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
        if ($imageSmall != '') {
            $data['image_small'] = $imageSmall;
        }
        if ($imageOg != '') {
            $data['page_og_image_seo'] = $imageOg;
        }

        return $this->db->update("sample_service", $data, "id='" . $service_id . "'");
    }

    private function updateSampleServiceImages($service_id, $service_images, $service_images_alts)
    {
        $data = [
            'images' => $service_images,
            'alts' => $service_images_alts
        ];

        return $this->db->update("sample_service", $data, "id = '" . $service_id . "'");
    }

    private function updateSampleServiceIsShow($service_id, $situation)
    {
        $data = [
            'is_show' => $situation
        ];

        return $this->db->update("sample_service", $data, 'id="' . $service_id . '"');
    }

    private function registerGuideService($service, $title, $brief_description, $guideImageAlt, $image, $icon)
    {
        $data = [
            'service_id' => $service,
            'title' => $title,
            'brief_description' => $brief_description,
            'language' => $this->language,
            'icon' => $icon
        ];
        if ($image != '') {
            $data['image'] = $image;
            $data['image_alt'] = $guideImageAlt;
        }


        return $this->db->insert("guide_service", $data);

    }

    private function getGuideServices()
    {

        $query = "select guide_service.*,services.id AS serId,services.title AS serTitle from `guide_service` join `services` on guide_service.service_id=services.id order by guide_service.id desc";
        return $this->db->rawQuery($query);
    }

    private function getGuideService($guide_id)
    {
        $data = [
            'id' => $guide_id
        ];

        return $this->db->select_q("guide_service", $data);
    }

    private function updateGuideService($guide_id, $service, $title, $brief_description, $guideImageAlt, $image, $icon)
    {
        $data = [
            'title' => $title,
            'service_id' => $service,
            'brief_description' => $brief_description,
            'language' => $this->language,
            'icon' => $icon
        ];
        if ($image != '') {
            $data['image'] = $image;
            $data['image_alt'] = $guideImageAlt;
        }


        return $this->db->update("guide_service", $data, "id='" . $guide_id . "'");
    }

    private function deleteGuideService($guide_id)
    {
        $query = "delete from `guide_service` where `id`='" . $guide_id . "' LIMIT 1";

        return $this->db->select_q($query);
    }

    private function registerServicePart($service, $title, $brief_description, $servicePartImageAlt, $image, $video)
    {
        $data = [
            'service_id' => $service,
            'title' => $title,
            'brief_description' => $brief_description,

        ];
        if ($image != '') {
            $data['image'] = $image;
            $data['alt'] = $servicePartImageAlt;
        }
        if ($video != '') {
            $data['video'] = $video;

        }
        return $this->db->insert("service_parts", $data);
    }

    public function getAllServiceParts()
    {
        $query = "select service_parts.*,services.id AS ServiceId,services.title AS ServiceTitle from service_parts join services on service_parts.service_id=services.id order by service_parts.id desc";

        return $this->db->rawQuery($query);
    }

    public function getServicePart($service_part_id)
    {
        $data = [
            'id' => $service_part_id
        ];

        return $this->db->select_q("service_parts", $data);
    }

    public function deleteServicePart($service_part_id)
    {
        $query = "delete from `service_parts` where `id`='" . $service_part_id . "' limit 1";

        return $this->db->select_old($query);
    }

    private function editServicePart($servicePart_id, $service, $title, $brief_description, $servicePartImageAlt, $image, $video)
    {
        $data = [
            'service_id' => $service,
            'title' => $title,
            'brief_description' => $brief_description,

        ];
        if ($image != '') {
            $data['image'] = $image;
            $data['alt'] = $servicePartImageAlt;
        }
        if ($video != '') {
            $data['video'] = $video;

        }
        return $this->db->update("service_parts", $data, "id='" . $servicePart_id . "'");
    }

    private function updateServiceIsVideoShow($service_id, $situation)
    {
        $data = [
            'show_video' => $situation
        ];

        return $this->db->update("services", $data, 'id="' . $service_id . '"');
    }

    private function registerKhadamat($title, $link, $brief_description, $icon,$khadamat_subject_id)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'link' => $link,
            'icon' => $icon,
            'khadamat_subject_id'=>$khadamat_subject_id
        ];

        return $this->db->insert("khadamats", $data);
    }

    private function getKhadamats($khadamat_subject_id)
    {
        return $this->db->select_q("khadamats", ["khadamat_subject_id"=>$khadamat_subject_id], "order by id desc");
    }

    private function getKhadamat($khadamat_id)
    {
        return $this->db->select_q("khadamats", ['id' => $khadamat_id], "order by id desc");
    }

    private function editKhadamat($khadamat_id, $title, $link, $brief_description, $icon)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'link' => $link,
            'icon' => $icon
        ];

        return $this->db->update("khadamats", $data, "id='" . $khadamat_id . "'");
    }

    private function deleteKhadamat($khadamat_id)
    {
        $query = "delete from `khadamats` where `id`='" . $khadamat_id . "' limit 1";

        return $this->db->select_old($query);
    }

    private function updateServiceIsComing($service_id, $situation)
    {
        $data = [
            'is_coming' => $situation
        ];

        return $this->db->update("services", $data, 'id="' . $service_id . '"');
    }

    private function getKhadamatsByTitle($title)
    {
        return $this->db->select_q("khadamats", ['main_title' => $title], "order by id desc");
    }

    private function registerKhadamatSubject($title_main, $main_brief_description)
    {
        $data = [
            'main_title' => $title_main,
            'main_description' => $main_brief_description
        ];

        return $this->db->insert("khadamat_subjects", $data);
    }

    private function deleteKhadamatSubject($khadamatSubject_id)
    {
        $query = "delete from khadamat_subjects where id='" . $khadamatSubject_id . "' limit 1";
        return $this->db->select_old($query);
    }

    private function getkhadamatSubjects()
    {
        return $this->db->select_q("khadamat_subjects", [], "order by id desc");
    }

    private function getKhadamatSubject($khadamatSubject_id)
    {
        return $this->db->select_q("khadamat_subjects", ['id' => $khadamatSubject_id]);
    }

    private function editKhadamatSubject($khadamat_subject_id, $title_main, $main_brief_description)
    {
        $data = [
            'main_title' => $title_main,
            'main_description' => $main_brief_description
        ];

        return $this->db->update("khadamat_subjects", $data, "id='" . $khadamat_subject_id . "'");
    }
}