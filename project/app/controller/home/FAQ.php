<?php

namespace App\controller\home;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class FAQ
{
    private $db;
    private $language;

    public function __construct()
    {
        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->language = getLanguage();
    }

    public function getFaqConstant()
    {
        return $this->db->select_q("faq_constants",['id'=>1]);
    }

    public function getFaqs()
    {
        return $this->db->select_q("faq",[],"order by id asc");
    }
}