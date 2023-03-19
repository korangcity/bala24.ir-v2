<?php

namespace App\controller\home;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Metatag
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $phraseBuilder;
    private $builder;
    private $language;
    private $pages;

    public function __construct()
    {

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();
        $this->pages = [1 => "وبلاگ", 2 => "سرویس", 3 => "نمونه سرویس", 4 => "خبر", 5 => "صفحات", 6 => "صفحه اصلی", 7 => "صفحه سرویس ها", 8 => "صفحه وبلاگ ها", 9 => "صفحه خبر ها", 10 => "صفحه نمونه سرویس ها"];
    }

    public function getMetatag($input)
    {
        $data=[
            'page_url'=>$input
        ];
        return $this->db->select_q("metatags",$data);
    }

}