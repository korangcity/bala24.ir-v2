<?php


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

        $main_url = $url1;
        $page_for = "guest";
        $TheCourse = "";

        if ($main_url == "") {
            $TheCourse = "home";
        }

        if ($main_url == "signin") {
            $TheCourse = "signin";
        }
        if ($main_url == "signup") {
            $TheCourse = "signup";
        }
        if ($main_url == "downloader") {
            $TheCourse = "downloader";
        }


        if ($TheCourse == '') {
            $output ['TheCourse'] = 404;
        }

        $output['TheCourse'] = $TheCourse;
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





