<?php


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
        $main_url = $url1;
        $page_for = "guest";
        $TheCourse = "";

        if($main_url!="" and !in_array($main_url,$genaralRoutes) and $url2=="-"){
            $TheCourse = "service";
        }

        if($main_url!="" and !in_array($main_url,$genaralRoutes) and $url2!="-"){
            $TheCourse = "sampleService";
        }

        if ($main_url == "") {
            $TheCourse = "home";
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





