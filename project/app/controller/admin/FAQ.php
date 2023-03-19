<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class FAQ
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
        if ($act == "createFaq") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.faq.create", ['token' => $token]);
        }

        if ($act == "createFaqProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('question', $_POST['question']);
                newRequest('answer', $_POST['answer']);


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
                    $question = sanitizeInput($_POST['question']);
                    $answer = sanitizeInput($_POST['answer']);

                else:
                    $question = sanitizeInputNonEn($_POST['question']);
                    $answer = sanitizeInputNonEn($_POST['answer']);
                endif;


                if (!empty(getErrors())) {
                    redirect('adminpanel/FAQ-createFaq?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerFaq($question, $answer);
                    redirect('adminpanel/FAQ-faqList');
                }
            }
        }

        if($act=="faqList"){
            $faqs=$this->getFaqs();
            renderView("admin.$this->language.faq.list", ['token' => $token, 'faqs' => $faqs]);
        }

        if($act=="faqDelete"){
            $faq_id=$option;
            $this->deleteFaq($faq_id);
            redirect("adminpanel/FAQ-faqList");
        }

        if($act=="editFaq"){
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $faq_id=$option;
            $faq=$this->getFaq($faq_id)[0];
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.faq.edit", ['token' => $token,'faq'=>$faq]);
        }

        if($act=="editFaqProcess"){
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('question', $_POST['question']);
                newRequest('answer', $_POST['answer']);

                $faq_id=sanitizeInput($_POST['faq_id']);
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
                    $question = sanitizeInput($_POST['question']);
                    $answer = sanitizeInput($_POST['answer']);

                else:
                    $question = sanitizeInputNonEn($_POST['question']);
                    $answer = sanitizeInputNonEn($_POST['answer']);
                endif;


                if (!empty(getErrors())) {
                    redirect('adminpanel/FAQ-editFaq-'.$faq_id.'?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editFaq($faq_id,$question, $answer);
                    redirect('adminpanel/FAQ-faqList');
                }
            }
        }

        if($act=="editFaConstant"){
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
           $faq_constant_id=$option;
           $faq_constant=$this->getFaqConstant($faq_constant_id)[0];

            renderView("admin.$this->language.faq.edit_faq_constant", ['token' => $token, 'faq_constant' => $faq_constant]);

        }

        if($act=="editFaConstantProcess"){
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

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


                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $first_link_title = sanitizeInput($_POST['first_link_title']);
                    $first_link_icon = sanitizeInput($_POST['first_link_icon']);
                    $first_link = sanitizeInput($_POST['first_link']);
                    $second_link_title = sanitizeInput($_POST['second_link_title']);
                    $second_link_icon = sanitizeInput($_POST['second_link_icon']);
                    $second_link = sanitizeInput($_POST['second_link']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $first_link_title = sanitizeInputNonEn($_POST['first_link_title']);
                    $first_link_icon = sanitizeInputNonEn($_POST['first_link_icon']);
                    $first_link = sanitizeInputNonEn($_POST['first_link']);
                    $second_link_title = sanitizeInputNonEn($_POST['second_link_title']);
                    $second_link_icon = sanitizeInputNonEn($_POST['second_link_icon']);
                    $second_link = sanitizeInputNonEn($_POST['second_link']);
                endif;

                $faq_constant_id=sanitizeInput($_POST['faq_constant_id']);

                if (!empty(getErrors())) {
                    redirect('adminpanel/FAQ-editFaConstant-'.$faq_constant_id.'?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editFaqConstant($faq_constant_id,$title, $brief_description, $first_link_title, $first_link_icon, $first_link, $second_link_title, $second_link_icon, $second_link);
                    redirect('adminpanel/FAQ-faqConstantList');
                }
            }
        }

        if($act=="faqConstantList"){
            $faq_constant=$this->getFaqConstant(1)[0];
            renderView("admin.$this->language.faq.list_faq_constant", ['token' => $token, 'faq_constant' => $faq_constant]);

        }


    }

    private function getFaqConstant($faq_constant_id)
    {
        $data=[
            'id'=>$faq_constant_id
        ];
        return $this->db->select_q("faq_constants",$data);
    }

    private function editFaqConstant($faq_constant_id,$title,$brief_description,$first_link_title,$first_link_icon,$first_link,$second_link_title,$second_link_icon,$second_link)
    {
        $data=[
            'title'=>$title,
            'brief_description'=>$brief_description,
            'first_link_title'=>$first_link_title,
            'first_link_icon'=>$first_link_icon,
            'first_link'=>$first_link,
            'second_link_title'=>$second_link_title,
            'second_link_icon'=>$second_link_icon,
            'second_link'=>$second_link
        ];

        return $this->db->update("faq_constants",$data,"id='".$faq_constant_id."'");
    }

    private function registerFaq($question,$answer)
    {
        $data=[
            'question'=>$question,
            'answer'=>$answer
        ];

        return $this->db->insert("faq",$data);
    }

    private function getFaqs()
    {
        return $this->db->select_q("faq",[],"order by id desc");
    }

    private function deleteFaq( $faq_id)
    {
        $query="delete from faq where id='".$faq_id."' limit 1";
        return $this->db->select_old($query);
    }

    private function getFaq($faq_id)
    {
        return $this->db->select_q("faq",['id'=>$faq_id]);
    }

    private function editFaq($faq_id,$question,$answer)
    {
        $data=[
            'question'=>$question,
            'answer'=>$answer
        ];

        return $this->db->update("faq",$data,"id='".$faq_id."'");
    }
}