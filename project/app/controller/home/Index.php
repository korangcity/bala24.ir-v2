<?php

namespace App\controller\home;

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
    private $pages;

    public function __construct()
    {

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();
        $service_obj=new Service();
        $this->pages=$service_obj->pages;
    }

    public function getPlanIndex($service_id)
    {
        $query="select * from plans";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('index',json_decode($item['planable_type']))){
                $plabableIds=json_decode($item['planable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($service_id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحه اصلی"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }
    public function getKhadamatsIndex($id)
    {
        $khadamats= $this->db->select_q("khadamats",[],"order by id desc");
        $result=[];
        foreach ($khadamats as $item) {
            if (in_array('index',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحه اصلی"]){
                        $result[]=$item;
                    }
                }

            }
        }


        return $result;
    }
    public function getStickFooterIndex($id)
    {
        $query="select * from stick_footer_pages";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('index',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحه اصلی"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }
    public function getVideoIndex($id)
    {
        $query="select * from videos";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('index',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);

                    if($id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["صفحه اصلی"]){
                        $result=$item;
                        break;
                    }
                }

            }
        }


        return $result;
    }

}