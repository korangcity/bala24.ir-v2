<?php

namespace App\controller\admin;

use Carbon\Carbon;
use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Blog
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

        if ($act == "createBlogCategory") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.blog.category_create", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "createBlogCategoryProcess") {

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
                        $image = file_upload($category_image, 'blog_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                        $imageOg = file_upload($category_image, 'blog_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Blog-createBlogCategory?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerBlogCategory($title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
                    redirect('adminpanel/Blog-blogCategoryList');
                }
            }
        }

        if ($act == "blogCategoryList") {
            $categories = $this->getBlogCategories($this->language);
            renderView("admin.$this->language.blog.category_list", ['categories' => $categories]);
        }

        if ($act == "blogCategoryEdit") {
            $category_id = $option;
            $category = $this->getBlogCategory($category_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.blog.category_edit", ['category' => $category, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "blogCategoryEditProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                $this->language = getLanguage();
                $category_id = sanitizeInput($_POST['category_id']);
                $category = $this->getBlogCategory($category_id)[0];

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
                        $image = file_upload($category_image, 'blog_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                        $imageOg = file_upload($category_image, 'blog_category', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Blog-blogCategoryEdit-' . $category_id . '?error=true');
                }
                if (empty(getErrors())) {
                    $this->editBlogCategory($category_id, $title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg);
                    redirect('adminpanel/Blog-blogCategoryList');
                }


            }
        }

        if ($act == "blogCategoryDelete") {
            $category_id = $option;
            $category = $this->getBlogCategory($category_id)[0];
            destroy_file($category['category_image']);
            destroy_file($category['page_og_image_seo']);

            $this->deleteBlogCategory($category_id);

            redirect('adminpanel/Blog-blogCategoryList');
        }

        if ($act == "getBlogCategorySeoInfo") {
            $category_id = sanitizeInput($_POST['category_id']);
            $blog_category_info = $this->getBlogCategory($category_id)[0];
            $result = '';
            if ($blog_category_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $blog_category_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $blog_category_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $blog_category_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $blog_category_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $blog_category_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $blog_category_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $blog_category_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $blog_category_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;

        }

        if ($act == "createBlog") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $categories = $this->getBlogCategories($this->language);

            renderView("admin.$this->language.blog.create", ['categories' => $categories, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "createBlogProcess") {

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

                foreach ($_POST['blogImageAlts'] as $blogImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($blogImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($blogImageAlt);
                    endif;
                }

                $imageAlts = json_encode($imageAlts);
                if (empty(getErrors())) {
                    if (!empty($_FILES['blogImages']) and !empty($_FILES['blogImages']['name'])) {
                        $blog_image = $_FILES['blogImages'];
                        if (count($_FILES['blogImages']['name']) != count($_POST['blogImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($blog_image, 'blog', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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

                    if (!empty($_FILES['blogOgImage']) and $_FILES['blogOgImage']['name'] != '') {
                        $blog_image = $_FILES['blogOgImage'];
                        $imageOg = file_upload($blog_image, 'blog', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Blog-createBlog?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerBlog($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);

                    redirect('adminpanel/Blog-blogList?success=true');
                }

            }
        }

        if ($act == "blogList") {

            $blogs = $this->getBlogs();

            renderView("admin.$this->language.blog.list", ['blogs' => $blogs]);

        }

        if ($act == "getBlogSeoInfo") {
            $blog_id = sanitizeInput($_POST['blog_id']);
            $blog_info = $this->getBlog($blog_id)[0];

            $result = '';
            if ($blog_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">page_url</th>';
                $result .= '<td>' . $blog_info["page_url"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">title</th>';
                $result .= '<td>' . $blog_info["page_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">description</th>';
                $result .= '<td>' . $blog_info["page_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $blog_info["page_keywords_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:title</th>';
                $result .= '<td>' . $blog_info["page_og_title_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:description</th>';
                $result .= '<td>' . $blog_info["page_og_description_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:type</th>';
                $result .= '<td>' . $blog_info["page_og_type_seo"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">og:image</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $blog_info["page_og_image_seo"] . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getBlogDetails") {
            $blog_id = sanitizeInput($_POST['blog_id']);
            $blog_info = $this->getBlog($blog_id)[0];

            $result = '';
            if ($blog_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">keywords</th>';
                $result .= '<td>' . $blog_info["keywords"] . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">h1_title</th>';
                $result .= '<td>' . $blog_info["h1_title"] . '</td>';
                $result .= "</tr>";
                foreach (json_decode($blog_info["images"]) as $key => $item) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">image' . ($key + 1) . '</th>';
                    $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $item . '" alt=""></td>';
                    $result .= "</tr>";
                    $result .= "<tr>";
                    $result .= '<th scope="row">alt' . ($key + 1) . '</th>';
                    $result .= '<td>' . (json_decode($blog_info["alts"]))[$key] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getBlogBriefdescription") {
            $blog_id = sanitizeInput($_POST['blog_id']);
            $blog_info = $this->getBlog($blog_id)[0];
            $result = '';
            echo $blog_info['brief_description'];
        }

        if ($act == "getBlogDescription") {
            $blog_id = sanitizeInput($_POST['blog_id']);
            $blog_info = $this->getBlog($blog_id)[0];
            $result = '';
            echo html_entity_decode($blog_info['description']);
        }

        if ($act == "blogDelete") {
            $blog_id = $option;
            $blog_info = $this->getBlog($blog_id)[0];
            foreach (json_decode($blog_info['images']) as $item) {
                destroy_file($item);
            }

            destroy_file($blog_info['page_og_image_seo']);

            $this->deleteBlog($blog_id);

            redirect('adminpanel/Blog-blogList?success=true');
        }

        if ($act == "blogEdit") {
            $blog_id = $option;
            $blog_info = $this->getBlog($blog_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();
            $categories = $this->getBlogCategories($this->language);
            renderView("admin.$this->language.blog.edit", ['categories' => $categories, 'blog' => $blog_info, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "editBlogProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();
                $blog_id = sanitizeInput($_POST['blog_id']);
                $blog_info = $this->getBlog($blog_id)[0];
                $blog_images_f = json_decode($blog_info['images']);
                $blog_images_f_alts = json_decode($blog_info['alts']);

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

                foreach ($_POST['blogImageAlts'] as $blogImageAlt) {
                    if ($this->language == 'en'):
                        $imageAlts[] = sanitizeInput($blogImageAlt);
                    else:
                        $imageAlts[] = sanitizeInputNonEn($blogImageAlt);
                    endif;
                }


                if (empty(getErrors())) {
                    if (!empty($_FILES['blogImages']) and !empty($_FILES['blogImages']['name'])) {
                        $blog_images = $_FILES['blogImages'];
                        if (count($_FILES['blogImages']['name']) != count($_POST['blogImageAlts'])) {
                            if ($this->language == 'en'):
                                setError('The number of alts should be the same as the number of images entered');
                            elseif ($this->language == 'fa'):
                                setError('تعداد alt با تعداد تصاویر وارد شده یاکسان باشد');
                            elseif ($this->language == 'ar'):
                                setError('يجب أن يكون عدد alt هو نفسه عدد الصور التي تم إدخالها.');
                            endif;
                        } else {
                            foreach ($imageAlts as $alt) {
                                $blog_images_f_alts[] = $alt;
                            }

                            $imageAlts = json_encode(array_values($blog_images_f_alts));
                        }
                        if (empty(getErrors())) {
                            $images = file_group_upload($blog_images, 'blog', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                                    $blog_images_f[] = $val;
                                }
                            }
                        }
                    }

                    $images = json_encode(array_values($blog_images_f));
                    if (!empty($_FILES['blogOgImage']) and $_FILES['blogOgImage']['name'] != '') {
                        $blogOgImage = $_FILES['blogOgImage'];
                        $imageOg = file_upload($blogOgImage, 'blog', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Blog-blogEdit-' . $blog_id . '?error=true');
                }

                if (empty(getErrors())) {

                    $v = $this->editBlog($blog_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg);
                    redirect('adminpanel/Blog-blogList?success=true');
                }


            }
        }

        if ($act == "blogDeleteImage") {
            $blog_id = sanitizeInput($_POST['blog_id']);
            $image_no = sanitizeInput($_POST['image_no']);
            $blog_info = $this->getBlog($blog_id)[0];
            $blog_images = json_decode($blog_info['images']);
            $blog_images_alts = json_decode($blog_info['alts']);
            destroy_file($blog_images[$image_no - 1]);
            unset($blog_images[$image_no - 1]);
            unset($blog_images_alts[$image_no - 1]);
            $blog_images = json_encode(array_values($blog_images));
            $blog_images_alts = json_encode(array_values($blog_images_alts));
            $this->updateBlogImages($blog_id, $blog_images, $blog_images_alts);
            echo true;

        }

    }

    private function registerBlogCategory($title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
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

        return $this->db->insert('blog_category', $data);

    }

    private function getBlogCategories($language)
    {
        $data = [
            'language' => $language
        ];
        return $this->db->select_q("blog_category", $data, "order by id desc");
    }

    private function getBlogCategory($category_id)
    {
        $data = [
            'id' => $category_id
        ];

        return $this->db->select_q("blog_category", $data);
    }

    private function editBlogCategory($category_id, $title, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $image, $imageOg)
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
        return $this->db->update('blog_category', $data, "id=$category_id");
    }

    private function deleteBlogCategory($category_id)
    {
        return $this->db->rawQuery("delete from `blog_category` where `id`=$category_id");
    }

    private function registerBlog($category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
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

        return $this->db->insert("blogs", $data);
    }

    private function getBlogs()
    {
        $query = "select blogs.*,blog_category.id AS CatId,blog_category.title AS CatTitle from `blogs` join `blog_category` on blog_category.id=blogs.category_id where blogs.language='" . $this->language . "' order by blogs.id desc";
        return $this->db->rawQuery($query);
    }

    public function getBlog($blog_id)
    {
        $data = [
            'id' => $blog_id
        ];

        return $this->db->select_q('blogs', $data);
    }

    private function deleteBlog($blog_id)
    {
        $query = "delete from `blogs` where `id`='" . $blog_id . "'";
        return $this->db->rawQuery($query);
    }

    private function updateBlogImages($blog_id, $blog_images, $blog_images_alts)
    {
        $data = [
            'images' => $blog_images,
            'alts' => $blog_images_alts
        ];

        return $this->db->update("blogs", $data, "id = '" . $blog_id . "'");
    }

    private function editBlog($blog_id, $category, $title, $brief_description, $description, $h1_title, $keywords, $pageUrl, $pageTitle, $pageDescription, $pageKeywords, $pageOgTitle, $pageOgDescription, $pageOgType, $imageAlts, $images, $imageOg)
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

        return $this->db->update("blogs", $data, "id='" . $blog_id . "'");
    }

}