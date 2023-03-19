<?php

namespace App\controller\home;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Page
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

    public function getPages()
    {
        return $this->db->select_q("pages",['language'=>'fa','is_show'=>1],"order by id desc");
    }

    public function getPage($pageUrl)
    {
        return $this->db->select_q("pages",['page_url'=>$pageUrl]);
    }

    public function getPlanPage($service_id)
    {
        $query="select * from plans";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('page',json_decode($item['planable_type']))){
                $plabableIds=json_decode($item['planable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($service_id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحات"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }
    public function getKhadamatsPage($id)
    {
        $khadamats= $this->db->select_q("khadamats",[],"order by id desc");
        $result=[];
        foreach ($khadamats as $item) {
            if (in_array('page',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحات"]){
                        $result[]=$item;
                    }
                }

            }
        }


        return $result;
    }
    public function getStickFooterPage($id)
    {
        $query="select * from stick_footer_pages";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('page',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحات"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }
    public function getVideoPage($id)
    {
        $query="select * from videos";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('page',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحات"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }


}