<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Program
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

        if ($act == "createProgram") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.programs.create", ['token' => $token]);
        }

        if ($act == "createProgramProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('link', $_POST['link']);
                newRequest('alt', $_POST['alt']);


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
                    $alt = sanitizeInput($_POST['alt']);

                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $link = sanitizeInputNonEn($_POST['link']);
                    $alt = sanitizeInputNonEn($_POST['alt']);

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


                if (empty(getErrors())) {
                    if (!empty($_FILES['programImage']) and $_FILES['programImage']['name'] != '') {
                        $program_image = $_FILES['programImage'];
                        $image = file_upload($program_image, 'program', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
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
                    redirect('adminpanel/Program-createProgram?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerProgram($title, $link, $alt, $image);
                    redirect('adminpanel/Program-programList');
                }
            }
        }

        if ($act == "programList") {
            $programs = $this->getPrograms();

            renderView("admin.$this->language.programs.list", ['programs' => $programs]);
        }

        if ($act == "editProgram") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $program_id = $option;
            $program = $this->getProgram($program_id)[0];

            renderView("admin.$this->language.programs.edit", ['token' => $token, "program" => $program]);
        }

        if ($act == "editProgramProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('link', $_POST['link']);
                newRequest('alt', $_POST['alt']);


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
                    $alt = sanitizeInput($_POST['alt']);

                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $link = sanitizeInputNonEn($_POST['link']);
                    $alt = sanitizeInputNonEn($_POST['alt']);

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
                $program_id = sanitizeInput($_POST['program_id']);
                $program = $this->getProgram($program_id)[0];

                $image = '';


                if (empty(getErrors())) {
                    if (!empty($_FILES['programImage']) and $_FILES['programImage']['name'] != '') {
                        $program_image = $_FILES['programImage'];
                        $image = file_upload($program_image, 'program', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($image == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($program['image']);
                        }
                    }


                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Program-editProgram-' . $program_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editProgram($program_id, $title, $link, $alt, $image);
                    redirect('adminpanel/Program-programList');
                }
            }
        }


        if($act=="programDelete"){
            $program_id = $option;
            $program = $this->getProgram($program_id)[0];
            destroy_file($program['image']);
            $this->deleteProgram($program_id);
            return true;
        }

    }

    private function registerProgram($title, $link, $alt, $image)
    {
        $data = [
            'title' => $title,
            'link' => $link,
            'alt' => $alt,
        ];

        if ($image) {
            $data['image'] = $image;
        }

        return $this->db->insert("programs", $data);
    }

    private function getPrograms()
    {
        return $this->db->select_q("programs", [], 'order by id desc');
    }

    private function getProgram($program_id)
    {
        $data = [
            'id' => $program_id
        ];
        return $this->db->select_q("programs", $data, 'order by id desc');
    }

    private function editProgram($program_id, $title, $link, $alt, $image)
    {
        $data = [
            'title' => $title,
            'link' => $link,
            'alt' => $alt,
        ];

        if ($image) {
            $data['image'] = $image;
        }

        return $this->db->update("programs", $data, 'id="' . $program_id . '"');
    }

    private function deleteProgram($program_id)
    {
        $query="delete from programs where id='".$program_id."' limit 1";

        return $this->db->select_old($query);
    }
}