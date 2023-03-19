<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;

class Slider
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $language;

    public function __construct()
    {
        !checkLogin() ? redirect("adminpanel/Auth-signin") : null;

        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->language = getLanguage();
    }


    public function act($act, $option = '')
    {

        if ($act == "createSlider") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.slider.create", ['token' => $token]);

        }

        if ($act == "createSliderProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('title', $_POST['title']);
                newRequest('description', $_POST['description']);
                newRequest('first_link_title', $_POST['first_link_title']);
                newRequest('first_link', $_POST['first_link']);
                newRequest('second_link_title', $_POST['second_link_title']);
                newRequest('second_link', $_POST['second_link']);

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }


                $title = sanitizeInputNonEn($_POST['title']);
                $description = sanitizeInputNonEn($_POST['description']);
                $first_link_title = sanitizeInputNonEn($_POST['first_link_title']);
                $first_link = sanitizeInputNonEn($_POST['first_link']);
                $second_link_title = sanitizeInputNonEn($_POST['second_link_title']);
                $second_link = sanitizeInputNonEn($_POST['second_link']);


                $images = '';


                $imageAlts = [];

                foreach ($_POST['sliderImageAlts'] as $sliderImageAlt) {

                    if ($sliderImageAlt != '') {

                        $imageAlts[] = sanitizeInputNonEn($sliderImageAlt);
                    } else {
                        $imageAlts[] = $title;
                    }

                }

                $imageAlts = json_encode($imageAlts);
                if (empty(getErrors())) {
                    if (!empty($_FILES['sliderImages']) and !empty($_FILES['sliderImages']['name'])) {
                        $slider_image = $_FILES['sliderImages'];

                        $images = file_group_upload($slider_image, 'slider', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($images == '') {
                            setError('تصویر را با فرمت صحیح وارد کنید');

                        }
                    }


                }


                if (!empty(getErrors())) {
                    redirect('adminpanel/Slider-createSlider?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->registerSlider($title, $description, $first_link_title, $first_link, $second_link_title, $second_link, $imageAlts, $images);

                    redirect('adminpanel/Slider-sliderList?success=true');
                }

            }
        }

        if ($act == "sliderList") {
            $sliders = $this->getSliders();

            renderView("admin.$this->language.slider.list", ['sliders' => $sliders]);
        }


        if ($act == "getSliderDetails") {
            $slider_id = sanitizeInput($_POST['slider_id']);
            $slider_info = $this->getSlider($slider_id)[0];

            $result = '';
            if ($slider_info) {

                $result .= "<tbody>";

                foreach (json_decode($slider_info["images"]) as $key => $item) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">image' . ($key + 1) . '</th>';
                    $result .= '<td> <img class="img-thumbnail" src="' . baseUrl(httpCheck()) . $item . '" alt=""></td>';
                    $result .= "</tr>";
                    $result .= "<tr>";
                    $result .= '<th scope="row">alt' . ($key + 1) . '</th>';
                    $result .= '<td>' . (json_decode($slider_info["alts"]))[$key] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "sliderDeleteImage") {
            $slider_id = 1;
            $image_no = sanitizeInput($_POST['image_no']);
            $slider_info = $this->getSlider($slider_id)[0];
            $slider_images = json_decode($slider_info['images']);
            $slider_images_alts = json_decode($slider_info['alts']);
            destroy_file($slider_images[$image_no - 1]);
            unset($slider_images[$image_no - 1]);
            unset($slider_images[$image_no - 1]);
            $slider_images = json_encode(array_values($slider_images));
            $slider_images_alts = json_encode(array_values($slider_images_alts));
            $this->updateSliderImages($slider_id, $slider_images, $slider_images_alts);
            echo true;
        }

        if ($act == "sliderEdit") {
            $slider_id = $option;
            $slider_info = $this->getSlider(1)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.slider.edit", ['slider' => $slider_info, 'token' => $token]);

        }

        if ($act == "editSliderProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                $slider = $this->getSlider(1)[0];

                $images = json_decode($slider['images']);
                $alts = json_decode($slider['alts']);


                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }


                $title = sanitizeInputNonEn($_POST['title']);
                $description = sanitizeInputNonEn($_POST['description']);
                $first_link_title = sanitizeInputNonEn($_POST['first_link_title']);
                $first_link = sanitizeInputNonEn($_POST['first_link']);
                $second_link_title = sanitizeInputNonEn($_POST['second_link_title']);
                $second_link = sanitizeInputNonEn($_POST['second_link']);


                $imagess = [];
                $imageAlts = [];


                    foreach ($_POST['sliderImageAlts'] as $sliderImageAlt) {

                        if ($sliderImageAlt != '') {

                            $imageAlts[] = sanitizeInputNonEn($sliderImageAlt);
                        }


                }


                if (empty(getErrors())) {
                    if (!empty($_FILES['sliderImages']) and !empty($_FILES['sliderImages']['name'])) {
                        $slider_image = $_FILES['sliderImages'];

                        $imagess = file_group_upload($slider_image, 'slider', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);
                        if ($imagess == '') {
                            setError('تصویر را با فرمت صحیح وارد کنید');

                        }
                    }


                }


               if(!empty(json_decode($imagess))){
                   $images = json_encode(array_merge($images, json_decode($imagess)));
                   $imageAlts = json_encode(array_merge($imageAlts, $alts));
               }else{
                   $images = json_encode($images);
                   $imageAlts = json_encode( $alts);
               }



                if (!empty(getErrors())) {
                    redirect('adminpanel/Slider-sliderEdit-1?error=true');
                }

                if (empty(getErrors())) {
                    $v = $this->editSlider($title, $description, $first_link_title, $first_link, $second_link_title, $second_link, $imageAlts, $images);

                    redirect('adminpanel/Slider-sliderList?success=true');
                }

            }
        }

        if($act=="getSliderImages"){
            $slider_id = 1;
            $slider_info = $this->getSlider($slider_id)[0];

            $result = '';
            if ($slider_info) {

                $result .= "<tbody>";
                foreach (json_decode($slider_info['images']) as $key=>$item) {


                $result .= "<tr>";
                $result .= '<th scope="row">تصویر</th>';
                $result .= '<td> <img src="' . baseUrl(httpCheck()) . $item . '" class="rounded avatar-xl"></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">alt</th>';
                $result .= '<td>'.json_decode($slider_info['alts'])[$key].'</td>';
                $result .= "</tr>";
                }
                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "sliderIsShow") {
            $slider_id = sanitizeInput($_POST['slider_id']);
            $situation = sanitizeInput($_POST['situation']);

            $this->updateSliderIsShow($slider_id, $situation);
            echo true;

        }


    }

    private function getSliders()
    {
        $data = [];
        return $this->db->select_q("sliders", $data, "order by id desc");
    }

    private function getSlider($slider_id)
    {
        $data = [
            'id' => $slider_id
        ];
        return $this->db->select_q("sliders", $data);
    }

    private function deleteSlider($slider_id)
    {
        $query = "delete from `sliders` where `id`='" . $slider_id . "' limit 1";
        return $this->db->select_old($query);
    }

    private function editSlider($title, $description, $first_link_title, $first_link, $second_link_title, $second_link, $imageAlts, $images)
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'first_link_title' => $first_link_title,
            'first_link' => $first_link,
            'second_link_title' => $second_link_title,
            'second_link' => $second_link,
            'alts' => $imageAlts,
        ];
        if ($images != '') {
            $data['images'] = $images;
        }
        return $this->db->update("sliders", $data, "id=1");
    }

//    private function updateSliderImages($slider_id, $slider_images, $slider_images_alts)
//    {
//        $data = [
//            'images' => $slider_images,
//            'alts' => $slider_images_alts
//        ];
//
//        return $this->db->update("sliders", $data, "id = '" . $slider_id . "'");
//    }

    private function updateSliderIsShow($slider_id, $situation)
    {
        $data = [
            'is_show' => $situation
        ];

        return $this->db->update("sliders", $data, 'id="' . $slider_id . '"');
    }

    private function registerSlider($title, $description, $first_link_title, $first_link, $second_link_title, $second_link, $imageAlts, $images)
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'first_link_title' => $first_link_title,
            'first_link' => $first_link,
            'second_link_title' => $second_link_title,
            'second_link' => $second_link,
            'alts' => $imageAlts,
        ];
        if ($images != '') {
            $data['images'] = $images;
        }


        return $this->db->insert("sliders", $data);
    }

    private function updateSliderImages($slider_id, $slider_images, $slider_images_alts)
    {
        $data = [
            'images' => $slider_images,
            'alts' => $slider_images_alts
        ];

        return $this->db->update("sliders", $data, "id='" . $slider_id . "'");
    }


}