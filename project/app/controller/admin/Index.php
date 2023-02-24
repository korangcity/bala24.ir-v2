<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Index
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
    }
    }