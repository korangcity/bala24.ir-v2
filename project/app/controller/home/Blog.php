<?php

namespace App\controller\home;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Blog
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

    public function getBlog($input)
    {

        $data = [
            'page_url' => $input,
            'is_show' => 1
        ];

        $query="select blogs.*,users.id AS Userid,users.name,users.avatar,users.address,users.departman from blogs join users on blogs.author=users.id where blogs.page_url='".$input."' AND blogs.is_show=1";
        $info = $this->db->rawQuery($query);

        if (!$info) {
            $data = [
                'id' => $input,
                'is_show' => 1
            ];


            $query="select blogs.*,users.id AS Userid,users.name,users.avatar,users.address,users.departman from blogs join users on blogs.author=users.id where blogs.id='".$input."' AND blogs.is_show=1";
            $info = $this->db->rawQuery($query);
        }

        return $info;
    }

    public function getBlogCategory($category_id)
    {
        $data = [
            'id' => $category_id
        ];

        return $this->db->select_q("blog_category", $data);
    }

    public function getPlan($blog_id)
    {
        $query="select * from plans";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
          if (in_array('blog',json_decode($item['planable_type']))){
                $plabableIds=json_decode($item['planable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);
                    if( $blog_id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["وبلاگ"]){
                        $result=$item;
                        break;
                    }
                }
            }
        }


        return $result;
    }

    public function getVideo($id)
    {
        $query="select * from videos";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
          if (in_array('blog',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);
                    if( $id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["وبلاگ"]){
                        $result=$item;
                        break;
                    }
                }
            }
        }


        return $result;
    }

    public function getStickFooter($id)
    {
        $query="select * from stick_footer_pages";
        $plansInfo=$this->db->rawQuery($query);


        foreach ($plansInfo as $item) {
            if (in_array('blog',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);
                    if( $id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["وبلاگ"]){
                        $result=$item;
                        break;
                    }
                }
            }
        }


        return $result;
    }

    public function getKhadamats($id)
    {
        $khadamats= $this->db->select_q("khadamats",[],"order by id desc");
        $result=[];
        foreach ($khadamats as $item) {
           if (in_array('blog',json_decode($item['pageable_type']))){
                $plabableIds=json_decode($item['pageable_id']);
                foreach ($plabableIds as $r=>$plabableId) {
                    $plabableIdd=explode("*",$plabableId);
                    if( $id==$plabableIdd[0] and $plabableIdd[1]==array_flip($this->pages)["وبلاگ"]){
                        $result[]=$item;

                    }
                }
            }
        }


        return $result;
    }

    public function getAuthorPaperNumber($author)
    {
        $query="select count(*) AS Author from blogs where author='".$author."'";
        return $this->db->rawQuery($query);
    }

    public function getOtherAuthors($author)
    {
        $query="select Distinct(blogs.author) from blogs where author!='".$author."' AND is_show=1";
        $info = $this->db->rawQuery($query);
        return $info;
    }

    public function getAuthorName($author)
    {
        $data=[
            'id'=>$author
        ];

        return $this->db->select_q("users",$data);
    }

    public function getBlogInCategory($blog_id,$category_id)
    {
        $query="select * from blogs where `id`!='{$blog_id}' and `category_id`='".$category_id."' limit 3";

        return $this->db->rawQuery($query);
    }
}