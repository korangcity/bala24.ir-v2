<?php

namespace App\controller\admin;

class Setting
{ 
    public function __construct()
    {
        !checkLogin() ? redirect("adminpanel/Auth-signin") : null;
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

    }

}