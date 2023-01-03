<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;


class Dashboard
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
        if ($act == "dashboard") {
            renderView("admin.$this->language.dashboard.index");
        }

        if ($act == "messages") {

            $messages = $this->getMessages();

            renderView("admin.messages.list", ['messages' => $messages]);
        }



    }

    private function getMessages()
    {
        $query = "select * from `messages` order  by `seen`,`id` desc";

        return $this->db->rawQuery($query);
    }

    private function getMessage($message_id)
    {
        $query = "select * from `messages` where `id`='" . $message_id . "'";

        return $this->db->rawQuery($query);
    }

    private function deleteMessage($message_id)
    {
        $query = "delete from `messages` where `id`={$message_id}";
        return $this->db->rawQuery($query);
    }

    private function updateMessageSatatus($message_id)
    {
        $data=[
            'seen'=>1
        ];

        return $this->db->update("messages",$data,"id='".$message_id."'");
    }


}