<?php


use App\controller\home\Page;
use App\controller\home\Service;
use App\controller\home\Setting;

function route($url1, $url2, $adminPanelUrl)
{

    $output = [];
    if ($url1 == "adminpanel") {

        $page_for = "admin";
        $admin_object_action = explode("-", $url2);
        $admin_object = $admin_object_action[0];
        $admin_action = $admin_object_action[1];
        $admin_option = $admin_object_action[2] ?? '';

        $className = getClass($admin_object);
        $obj = new $className();
        $obj->act($admin_action, $admin_option);
    } elseif ($url1 == "sitemap.xml") {
        $page_for = "sitemap";

    } else {

        $setting=new Setting();
        $genaralRoutes=$setting->getGeneralRoutes();
        $service_obj=new Service();
        $service_categories=$service_obj->getServiceCategories();
        $service_categories_title=[];
        foreach ($service_categories as $service_category) {
            $service_categories_title[]=$service_category['enTitle'];
        }
        $page=new Page();
        $pages=$page->getPages();
        $main_url = $url1;
        $page_for = "guest";
        $TheCourse = "";

        if($main_url!="" and in_array($main_url,$service_categories_title) and $url2!="-"){
            $TheCourse = "service";
        }elseif($main_url!="" and $main_url!="blog" and !in_array($main_url,$genaralRoutes) and $url2!="-"){
            $TheCourse = "sampleService";
        }elseif ($main_url == "") {
            $TheCourse = "home";
        }elseif ($main_url == "services") {
            $TheCourse = "services";
        }elseif ($main_url == "search") {
            $TheCourse = "search";
        }elseif ($main_url == "blog") {
            $TheCourse = "blog";
        }elseif ($main_url == "blogs") {
            $TheCourse = "blogs";
        }elseif ($main_url == "news" and $url2!="-") {
            $TheCourse = "news";
        }elseif ($main_url == "news" and $url2=="-") {
            $TheCourse = "newss";
        }elseif ($main_url == "signin") {
            $TheCourse = "signin";
        }elseif ($main_url == "signout") {
            $TheCourse = "signout";
        }elseif ($main_url == "signup") {
            $TheCourse = "signup";
        }elseif ($main_url == "two-step-verification") {
            $TheCourse = "two-step-verification";
        }elseif ($main_url == "user-complete-information") {
            $TheCourse = "user-complete-information";
        }elseif ($main_url == "faq") {
            $TheCourse = "faq";
        }elseif ($main_url == "forgot-password") {
            $TheCourse = "forgot-password";
        }elseif ($main_url == "two-step-verification-forgot-password") {
            $TheCourse = "two-step-verification-forgot-password";
        }elseif ($main_url == "user-create-new-password") {
            $TheCourse = "user-create-new-password";
        }

        foreach ($pages as $page) {
            if($main_url==$page['page_url']){
                $TheCourse = 'page/'.$page['page_url'];
            }
        }



        if ($TheCourse == '') {
            $output ['TheCourse'] = 404;
        }
        
        

        $output['TheCourse'] = $TheCourse;
        $output['main'] = $main_url;
        $output['single'] = $url2;


    }
    $output['page_for'] = $page_for;

    return $output;
}

function getClass($admin_object)
{
    $namespace = '\\App\\controller\\admin\\';
    $className = $namespace . $admin_object;
    return $className;
}





