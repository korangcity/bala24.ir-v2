<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Contactus
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


    public function act($act,$option='')
    {
        if($act=="showMessages"){
            $messages=$this->getMessages();
            renderView("admin.$this->language.contactus.index", ['messages' => $messages]);

        }

        if($act=="messageDelete"){
            $message_id=$option;
            $this->deleteMessage($message_id);
            redirect("adminpanel/Contactus-showMessages");
        }

        if($act=="getMessageContent"){
            $message_id=sanitizeInput($_POST['message_id']);
            $message=$this->getMessage($message_id)[0];
            echo html_entity_decode($message['message']);
        }

    }

    public function getMessages()
    {
        return $this->db->select_q("messages",[],"order by is_shown,id asc");
    }

    private function deleteMessage($message_id)
    {
        $query="delete from `messages` where `id`='".$message_id."' limit 1";

        return $this->db->select_old($query);
    }

    private function getMessage($message_id)
    {
        $data=[
            'id'=>$message_id
        ];
        $this->db->update("messages",['is_shown'=>1],"id='".$message_id."'");

        return $this->db->select_q("messages",$data);
    }

}