<?php

namespace App\controller\home;

use App\controller\DTC;
use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Auth
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $phraseBuilder;
    private $builder;
    private $language;
    public $pages;

    public function __construct()
    {

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();

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

    public function register($mobile)
    {

        $user_code=generateRandomString(4,1,0);
        $data=[
            'mobile'=>$mobile,
            'sms_code'=>$user_code
        ];


        return ['user_id'=>$this->db->insert("users",$data),'user_code'=>$user_code];
    }

    public function checkUserExist($mobile)
    {
        return $this->db->select_q("users",['mobile'=>$mobile]);
    }

    public function updateUserInfo($user_id,$name,$email,$password)
    {
        $data=[
            'name'=>$name,
            'email'=>$email,
            'password'=>$password
        ];

        $this->db->update("users",$data,'id="'.$user_id.'"');

    }
    public function updateUserPassword($user_mobile,$password)
    {
        $data=[
            'password'=>$password
        ];

        $this->db->update("users",$data,'mobile="'.$user_mobile.'"');
    }

    public function getUserInfo($user_id)
    {
        $dtc_obj=new DTC();
        $user_id=$dtc_obj->dec($user_id);
        $query="select `name`,`mobile`,`avatar` from `users` where `id`='".$user_id."'";
        return $this->db->rawQuery($query);
    }

    public function signin($mobile,$password)
    {
        $dtc_obj=new DTC();
        $data=[
            'mobile'=>$mobile
        ];
        $info=$this->db->select_q('users',$data)[0];
        $client_entered_password=$dtc_obj->create_checksum($password);
        if($info['password']==$client_entered_password)
            return [true,$info['id']];
        return false;

    }

    public function sendForgotPasswordCode($mobile)
    {
        $user_code=generateRandomString(4,1,0);
        $data=[
            'sms_code'=>$user_code
        ];
        $this->db->update("users",$data,"mobile='".$mobile."'");

        return ['user_code'=>$user_code];
    }

}