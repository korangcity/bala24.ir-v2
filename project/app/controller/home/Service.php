<?php

namespace App\controller\home;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Service
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

    public function getSecurityCodes(){
        $token = $this->easyCSRF->generate('my_token');
        $this->builder->build();
        $_SESSION['phrase'] = $this->builder->getPhrase();
        return ['token'=>$token,'builder' => $this->builder];
    }

    public function checkCsrf()
    {
        return $this->easyCSRF->check('my_token', $_POST['token']);
    }

    public function getServices()
    {
        $data = [
            'is_show' => 1
        ];

        $info = $this->db->select_q("services", $data);

        return $info;
    }

    public function getService($input)
    {

        $data = [
            'page_url' => $input,
            'is_show' => 1
        ];

        $info = $this->db->select_q("services", $data);

        if (!$info) {
            $data = [
                'id' => $input,
                'is_show' => 1
            ];

            $info = $this->db->select_q("services", $data);
        }

        return $info;
    }

    public function getSampleService($input)
    {

        $data = [
            'page_url' => $input,
            'is_show' => 1
        ];

        $info = $this->db->select_q("sample_service", $data);

        if (!$info) {
            $data = [
                'id' => $input,
                'is_show' => 1
            ];

            $info = $this->db->select_q("sample_service", $data);
        }

        return $info;
    }

    public function getServiceCategory($category_id)
    {
        $data = [
            'id' => $category_id
        ];

        return $this->db->select_q("service_category", $data);
    }


    public function getServiceGuides($service_id)
    {

        $data = [
            'service_id' => $service_id
        ];
        return $this->db->select_q("guide_service", $data, "order by id desc");
    }

    public function getSampleServices($service_id)
    {

        $query = "select * from `sample_service` where `service_id`='" . $service_id . "' and `is_show`=1 order by `id` desc limit 8";

        return $this->db->rawQuery($query);
    }

    public function getServiceParts($id)
    {
        $query = "select * from `service_parts` where `service_id`='" . $id . "' order by `id` desc";

        return $this->db->rawQuery($query);
    }

    public function getServiceCategories()
    {
        $data = [
            'language' => getLanguage()
        ];
        return $this->db->select_q("service_category", $data);
    }

    public function getServiceSamples()
    {
        return $this->db->select_q("sample_service", []);
    }

    public function getPlan($service_id)
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
                    }elseif( $service_id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["سرویس"]){
                        $result=$item;
                        break;
                    }
                }

            }elseif (in_array('service',json_decode($item['planable_type']))){
                $plabableIds=json_decode($item['planable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);
                    if( $service_id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["سرویس"]){
                        $result=$item;
                        break;
                    }
                }
            }
        }


        return $result;
    }

    public function getTimePeriods()
    {
        $data = [

        ];

        return $this->db->select_q("plan_times", $data);
    }

    public function getSubPlan($plan_id)
    {
//        $query="select plan_feature_price.id AS ID,plan_feature_price.plan_feature_id,plan_feature_price.time_period_id,plan_feature_price.price,plan_feature_price.particular,plan_features.* from plan_feature_price left join plan_features
//                on plan_feature_price.plan_feature_id=plan_features.id where plan_features.plan_id='".$plan_id."' order by plan_feature_price.id desc";
        $data = [
            'plan_id' => $plan_id
        ];

        return $this->db->select_q("plan_features",$data,"order by id desc");
    }

    public function getPlanFeaturePrices($subPlan_id)
    {
        $data = [
            'plan_feature_id' => $subPlan_id
        ];

        return $this->db->select_q("plan_feature_price",$data,"order by id desc");
    }

    public function getKhadamats()
    {
        return $this->db->select_q("khadamats",[],"order by id desc");
    }

    public function registerMessage($name, $email,$subject, $message)
    {
        $data=[
            'name'=>$name,
            'email'=>$email,
            'subject'=>$subject,
            'message'=>$message
        ];

        return $this->db->insert("messages",$data);
    }

}