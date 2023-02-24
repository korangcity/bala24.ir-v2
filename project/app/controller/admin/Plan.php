<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;


class Plan
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $language;
    private $pages;
/*
 * index => i
 * services => s
 * blogs => b
 * news => n
 * sampleServices => w
 */

    public function __construct()
    {
        !checkLogin() ? redirect("adminpanel/Auth-signin") : null;
        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->language = getLanguage();
        $this->pages = [1 => "وبلاگ", 2 => "سرویس", 3 => "نمونه سرویس", 4 => "خبر", 5 => "صفحات", 6 => "صفحه اصلی", 7 => "صفحه سرویس ها", 8 => "صفحه وبلاگ ها", 9 => "صفحه خبر ها", 10 => "صفحه نمونه سرویس ها"];
    }

    public function act($act, $option = "")
    {
        if ($act == "createPlanTime") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.plan.time_create", ['token' => $token]);
        }

        if ($act == "createPlanTimeProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('time_period', $_POST['time_period']);
                newRequest('title', $_POST['title']);
                newRequest('title_value', $_POST['title_value']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $time_period = sanitizeInput($_POST['time_period']);
                    $title_value = sanitizeInput($_POST['title_value']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                    $title_value = sanitizeInputNonEn($_POST['title_value']);
                endif;

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }
                if ($time_period == '') {
                    if ($this->language == 'en'):
                        setError('enter time period value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دوره زمانی را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل فترة بشكل صحيح');
                    endif;
                }
                if ($title_value == '') {
                    if ($this->language == 'en'):
                        setError('enter time value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار زمان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل مقدار الوقت بشكل صحيح');
                    endif;
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-createPlanTime?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerPlanTime($title, $time_period, $title_value);
                    redirect('adminpanel/Plan-planTimeList');
                }

            }
        }

        if ($act == "planTimeList") {
            $times = $this->getTimes();
            renderView("admin.$this->language.plan.time_list", ['times' => $times]);
        }

        if ($act == "editPlanTime") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $plan_time_id = $option;
            $time = $this->getTime($plan_time_id)[0];
            renderView("admin.$this->language.plan.time_edit", ['token' => $token, 'time' => $time]);
        }

        if ($act == "editPlanTimeProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('time_period', $_POST['time_period']);
                newRequest('title', $_POST['title']);
                newRequest('title_value', $_POST['title_value']);

                $time_id = sanitizeInput($_POST['time_id']);
                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $time_period = sanitizeInput($_POST['time_period']);
                    $title_value = sanitizeInput($_POST['title_value']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                    $title_value = sanitizeInputNonEn($_POST['title_value']);
                endif;

                if (strlen($title) <= 2) {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }
                if ($time_period == '') {
                    if ($this->language == 'en'):
                        setError('enter time period value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دوره زمانی را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل فترة بشكل صحيح');
                    endif;
                }
                if ($title_value == '') {
                    if ($this->language == 'en'):
                        setError('enter time value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار زمان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل مقدار الوقت بشكل صحيح');
                    endif;
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-editPlanTime' . $time_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editPlanTime($time_id, $title, $time_period, $title_value);
                    redirect('adminpanel/Plan-planTimeList');
                }

            }
        }

        if ($act == "planTimeDelete") {
            $time_id = $option;
            $this->deletePlanTime($time_id);
            redirect('adminpanel/Plan-planTimeList');
        }

        if ($act == "createPlan") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $time_periods = $this->getTimes();
            renderView("admin.$this->language.plan.plan_create", ['time_periods' => $time_periods, 'token' => $token, "pages" => $this->pages]);
        }

        if ($act == "getPageChildren") {

            $page_ids = sanitizeInput($_POST['page_id']);
            $pagee_id = $_POST['pagee_id'] ? sanitizeInput($_POST['pagee_id']) : null;

            $output1 = [];
            $output2 = [];
            $output3 = [];
            $output4 = [];
            $output5 = [];
            $output6 = [];
            $output7 = [];
            $output8 = [];
            $output9 = [];
            $output10 = [];
            foreach ($page_ids as $page_id) {
                if ($page_id == 1) {
                    $output1 = $this->getBlogs();
                    foreach ($output1 as $key => $item1) {
                        $output1[$key]['page_idd'] = 1;
                    }

                } elseif ($page_id == 2) {
                    $output2 = $this->getServices();
                    foreach ($output2 as $key2 => $item2) {
                        $output2[$key2]['page_idd'] = 2;
                    }
                } elseif ($page_id == 3) {
                    $output3 = $this->getSampleServices();
                    foreach ($output3 as $key3 => $item3) {
                        $output3[$key3]['page_idd'] = 3;
                    }
                } elseif ($page_id == 4) {
                    $output4 = $this->getNews();
                    foreach ($output4 as $key4 => $item4) {
                        $output4[$key4]['page_idd'] = 4;
                    }
                } elseif ($page_id == 5) {
                    $output5 = $this->getPages();
                    foreach ($output5 as $key5 => $item5) {
                        $output5[$key5]['page_idd'] = 5;
                    }
                } elseif ($page_id == 6) {
                    $output6[0]['page_idd'] = 6;
                    $output6[0]['id'] = 'i';
                    $output6[0]['title'] = $this->pages[6];
                }elseif ($page_id == 7) {
                    $output7[0]['page_idd'] = 7;
                    $output7[0]['id'] = 's';
                    $output7[0]['title'] = $this->pages[7];
                }elseif ($page_id == 8) {
                    $output8[0]['page_idd'] = 8;
                    $output8[0]['id'] = 'b';
                    $output8[0]['title'] = $this->pages[8];
                }elseif ($page_id == 9) {
                    $output9[0]['page_idd'] = 9;
                    $output9[0]['id'] = 'n';
                    $output9[0]['title'] = $this->pages[9];
                }elseif ($page_id == 10) {
                    $output10[0]['page_idd'] = 10;
                    $output10[0]['id'] = 'w';
                    $output10[0]['title'] = $this->pages[10];
                }
            }
            $output = array_merge($output1, $output2, $output3, $output4, $output5, $output6, $output7, $output8, $output9, $output10);

            $result = "<option value='' >انتخاب کنید</option>";


            foreach ($output as $item) {
                $selectedTrue = false;
                foreach ($pagee_id as $it) {
                    $check = explode(" ", $it);
                    if ($check[0] == $item['id'] and $check[1] == $item['page_idd']) {
                        $selectedTrue = true;
                        break;
                    }
                }
                $result .= "<option value='" . $item['id'] . "*" . $item['page_idd'] . "' " . ($selectedTrue ? 'selected' : '') . ">" . $item['title'] . "</option>";
            }

            echo $result;
        }

        if ($act == "createPlanProcess") {
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('pagee', $_POST['pagee']);
                newRequest('page_children', $_POST['page_children']);
                newRequest('time_period', $_POST['time_period']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $time_period = sanitizeInput($_POST['time_period']);
                    $pagee = sanitizeInput($_POST['pagee']);
                    $page_children = sanitizeInput($_POST['page_children']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                    $pagee = sanitizeInputNonEn($_POST['pagee']);
                    $page_children = sanitizeInputNonEn($_POST['page_children']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                endif;

                if ($title == '') {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

                if ($time_period == '') {
                    if ($this->language == 'en'):
                        setError('enter time period value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دوره زمانی را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل فترة بشكل صحيح');
                    endif;
                }

                if ($pagee == '') {
                    if ($this->language == 'en'):
                        setError('enter position value correctly');
                    elseif ($this->language == 'fa'):
                        setError('جایگاه را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل موضع بشكل صحيح');
                    endif;
                }
                $planable_type = [];
                foreach ($pagee as $item) {
                    if ($item == 1) {
                        $planable_type[] = "blog";
                    } elseif ($item == 2) {
                        $planable_type[] = "service";
                    } elseif ($item == 3) {
                        $planable_type[] = "service_sample";
                    } elseif ($item == 4) {
                        $planable_type[] = "news";
                    } elseif ($item == 5) {
                        $planable_type[] = "page";
                    } elseif ($item == 6) {
                        $planable_type[] = "index";
                    }
                }
                $planable_type = json_encode($planable_type);


//                if ($page_children == '') {
//                    if ($this->language == 'en'):
//                        setError('enter page value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('صفحه را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل صفحة بشكل صحيح');
//                    endif;
//                }

                $time_period = json_encode($time_period);
//                $checkIfPlanExist=$this->checkIfPlanExist($planable_type,$page_children)[0];
//                if($checkIfPlanExist){
//                    if ($this->language == 'en'):
//                        setError('plan already exist');
//                    elseif ($this->language == 'fa'):
//                        setError('پلن مورد نظر در سیستم موجود است');
//                    elseif ($this->language == 'ar'):
//                        setError('الخطة المطلوبة متوفرة في النظام');
//                    endif;
//                }
                $planable_id = json_encode($page_children);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-createPlan?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerPlan($title, $time_period, $planable_type, $brief_description, $planable_id);
                    redirect('adminpanel/Plan-planList');
                }

            }
        }

        if ($act == "planList") {
            $plans = $this->getPlans();
            $time_periods = $this->getTimes();
            renderView("admin.$this->language.plan.plan_list", ['time_periods' => $time_periods, 'token' => $token, 'plans' => $plans]);
        }

        if ($act == "planDelete") {
            $plan_id = $option;
            $this->deletePlan($plan_id);
            redirect('adminpanel/Plan-planList');
        }

        if ($act == "editPlan") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $time_periods = $this->getTimes();
            $plan_id = $option;
            $plan = $this->getPlan($plan_id)[0];

            renderView("admin.$this->language.plan.plan_edit", ['plan' => $plan, 'time_periods' => $time_periods, 'token' => $token, "pages" => $this->pages]);

        }

        if ($act == "editPlanProcess") {
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('pagee', $_POST['pagee']);
                newRequest('page_children', $_POST['page_children']);
                newRequest('time_period', $_POST['time_period']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $time_period = sanitizeInput($_POST['time_period']);
                    $pagee = sanitizeInput($_POST['pagee']);
                    $page_children = sanitizeInput($_POST['page_children']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                    $pagee = sanitizeInputNonEn($_POST['pagee']);
                    $page_children = sanitizeInputNonEn($_POST['page_children']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                endif;

                $plan_id = sanitizeInput($_POST['plan_id']);
                if ($title == '') {
                    if ($this->language == 'en'):
                        setError('enter title value correctly');
                    elseif ($this->language == 'fa'):
                        setError('عنوان را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل العنوان بشكل صحيح');
                    endif;
                }

                if ($time_period == '') {
                    if ($this->language == 'en'):
                        setError('enter time period value correctly');
                    elseif ($this->language == 'fa'):
                        setError('دوره زمانی را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل فترة بشكل صحيح');
                    endif;
                }

                if ($pagee == '') {
                    if ($this->language == 'en'):
                        setError('enter position value correctly');
                    elseif ($this->language == 'fa'):
                        setError('جایگاه را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل موضع بشكل صحيح');
                    endif;
                }

                $planable_type = [];
                foreach ($pagee as $item) {
                    if ($item == 1) {
                        $planable_type[] = "blog";
                    } elseif ($item == 2) {
                        $planable_type[] = "service";
                    } elseif ($item == 3) {
                        $planable_type[] = "service_sample";
                    } elseif ($item == 4) {
                        $planable_type[] = "news";
                    } elseif ($item == 5) {
                        $planable_type[] = "page";
                    }
                }
                $planable_type = json_encode($planable_type);


                if ($page_children == '') {
                    if ($this->language == 'en'):
                        setError('enter page value correctly');
                    elseif ($this->language == 'fa'):
                        setError('صفحه را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل صفحة بشكل صحيح');
                    endif;
                }

                $time_period = json_encode($time_period);
                $planable_id = json_encode($page_children);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-editPlan-' . $plan_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editPlan($plan_id, $title, $time_period, $planable_type, $brief_description, $planable_id);
                    redirect('adminpanel/Plan-planList');
                }

            }
        }

        if ($act == "createPlanFeature") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $plans = $this->getPlans();
            $time_periods = $this->getTimes();
            renderView("admin.$this->language.plan.plan_feature_create", ['time_periods' => $time_periods, 'plans' => $plans, 'token' => $token]);

        }

        if ($act == "getPlanTimePeriods") {
            $plan_id = sanitizeInput($_POST['plan_id']);
            $plan = $this->getPlan($plan_id)[0];
            $times = json_decode($plan['time_period']);
            $time_periods = $this->getTimes();
            $info = [];
            foreach ($times as $time) {
                foreach ($time_periods as $time_period) {
                    if ($time == $time_period['id']) {
                        $info[] = $time_period;
                    }
                }
            }

            $result = '<option value=""> انتخاب کنید</option>';

            foreach ($info as $item) {
                $result .= '<option value="' . $item['id'] . '">  ' . $item['title'] . '</option>';
            }

            echo $result;
        }

        if ($act == "createPlanFeatureProcess") {
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('plan', $_POST['plan']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                newRequest('positive_features', $_POST['positive_features']);
                newRequest('negative_features', $_POST['negative_features']);
                newRequest('icon', $_POST['icon']);


                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $plan = sanitizeInput($_POST['plan']);
                    $price = sanitizeInput($_POST['price']);
                    $positive_features = sanitizeInput($_POST['positive_features']);
                    $negative_features = sanitizeInput($_POST['negative_features']);
                    $icon = sanitizeInput($_POST['icon']);
                    $time_period = sanitizeInput($_POST['time_period']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $plan = sanitizeInputNonEn($_POST['plan']);
                    $price = sanitizeInputNonEn($_POST['price']);
                    $positive_features = sanitizeInputNonEn($_POST['positive_features']);
                    $negative_features = sanitizeInputNonEn($_POST['negative_features']);
                    $icon = sanitizeInputNonEn($_POST['icon']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                endif;

//                $checkIfSubPlanExist=$this->checkIfSubPlanExist($plan)[0];
//                if($checkIfPlanExist){
//                    if ($this->language == 'en'):
//                        setError('subplan already exist');
//                    elseif ($this->language == 'fa'):
//                        setError('ویژگی مورد نظر در سیستم موجود است');
//                    elseif ($this->language == 'ar'):
//                        setError('الميزة المطلوبة متوفرة في النظام');
//                    endif;
//                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-createPlanFeature?error=true');
                }

                $positive_features = json_encode(array_filter($positive_features));
                $negative_features = json_encode(array_filter($negative_features));

                if (empty(getErrors())) {
                    $res = $this->registerPlanFeature($title, $brief_description, $plan, $positive_features, $negative_features, $icon);
                    redirect('adminpanel/Plan-planFeatureList');
                }

            }
        }

        if ($act == "planFeatureList") {
            $plan_features = $this->getPlanFeatures();
            $time_periods = $this->getTimes();
            $plans = $this->getPlans();
            $plan_feature_prices = $this->getPlanFeaturePrices();
            renderView("admin.$this->language.plan.plan_feature_list", ['plan_feature_prices' => $plan_feature_prices, 'plan_features' => $plan_features, 'time_periods' => $time_periods, 'plans' => $plans, 'token' => $token]);

        }

        if ($act == "getPlanFeaturePositive") {
            $feature_id = sanitizeInput($_POST['feature_id']);
            $feature = $this->getPlanFeature($feature_id)[0];
            $result = '';

            foreach (json_decode($feature['positive_features']) as $item) {
                $result .= "<tr><td>$item</td></tr>";
            }
            echo $result;
        }

        if ($act == "getPlanFeatureNegative") {
            $feature_id = sanitizeInput($_POST['feature_id']);
            $feature = $this->getPlanFeature($feature_id)[0];
            $result = '';

            foreach (json_decode($feature['negative_features']) as $item) {
                $result .= "<tr><td>$item</td></tr>";
            }
            echo $result;
        }

        if ($act == "editPlanFeature") {

        }

        if ($act == "updatePlanFeaturePrice") {
            $id = sanitizeInput($_POST['id']);
            $price = sanitizeInput($_POST['price']);

            $this->updatePlanPrice($id, $price);
            echo true;
        }

        if ($act == "planFeaturePriceDelete") {
            $planFeaturePriceId = $option;
            $plan_feature_prices = $this->getPlanFeaturePricesById($planFeaturePriceId)[0];

            $info = $this->getPlanFeaturePricesByFeatureId($plan_feature_prices['plan_feature_id']);
            if (count($info) > 1) {
                $this->deletePlanFeaturePrice($planFeaturePriceId);
            } else {
                $this->deletePlanFeature($plan_feature_prices['plan_feature_id']);
            }

            redirect('adminpanel/Plan-planFeatureList');
        }

        if ($act == "editPlanFeature") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $plans = $this->getPlans();
            $time_periods = $this->getTimes();
            $planFeatureId = $option;
            $planFeature = $this->getPlanFeature($planFeatureId)[0];

            renderView("admin.$this->language.plan.plan_feature_edit", ['planFeature' => $planFeature, 'time_periods' => $time_periods, 'plans' => $plans, 'token' => $token]);

        }

        if ($act == "editPlanFeatureProcess") {
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('plan', $_POST['plan']);
                newRequest('title', $_POST['title']);
                newRequest('brief_description', $_POST['brief_description']);

                newRequest('positive_features', $_POST['positive_features']);
                newRequest('negative_features', $_POST['negative_features']);
                newRequest('icon', $_POST['icon']);


                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $brief_description = sanitizeInput($_POST['brief_description']);
                    $plan = sanitizeInput($_POST['plan']);
                    $price = sanitizeInput($_POST['price']);
                    $positive_features = sanitizeInput($_POST['positive_features']);
                    $negative_features = sanitizeInput($_POST['negative_features']);
                    $icon = sanitizeInput($_POST['icon']);
                    $time_period = sanitizeInput($_POST['time_period']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $brief_description = sanitizeInputNonEn($_POST['brief_description']);
                    $plan = sanitizeInputNonEn($_POST['plan']);
                    $price = sanitizeInputNonEn($_POST['price']);
                    $positive_features = sanitizeInputNonEn($_POST['positive_features']);
                    $negative_features = sanitizeInputNonEn($_POST['negative_features']);
                    $icon = sanitizeInputNonEn($_POST['icon']);
                    $time_period = sanitizeInputNonEn($_POST['time_period']);
                endif;

                $plan_feature_id = sanitizeInput($_POST['plan_feature_id']);
//                $checkIfSubPlanExist=$this->checkIfSubPlanExist($plan)[0];
//                if($checkIfPlanExist){
//                    if ($this->language == 'en'):
//                        setError('subplan already exist');
//                    elseif ($this->language == 'fa'):
//                        setError('ویژگی مورد نظر در سیستم موجود است');
//                    elseif ($this->language == 'ar'):
//                        setError('الميزة المطلوبة متوفرة في النظام');
//                    endif;
//                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Plan-editPlanFeature' . $plan_feature_id . '?error=true');
                }

                $positive_features = json_encode(array_filter($positive_features));
                $negative_features = json_encode(array_filter($negative_features));

                if (empty(getErrors())) {
                    $res = $this->editPlanFeature($plan_feature_id, $title, $brief_description, $plan, $positive_features, $negative_features, $icon);
                    redirect('adminpanel/Plan-planFeatureList');
                }

            }
        }

        if ($act == "planFeaturePriceIsParticular") {
            $situation = sanitizeInput($_POST['situation']);
            $plan_feature_price_id = sanitizeInput($_POST['plan_feature_price_id']);
            $this->updatePlanFeaturePriceParticular($situation, $plan_feature_price_id);
            echo true;
        }

        if ($act == "createStickFooter") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.plan.create_stickFooter", ['token' => $token, 'pages' => $this->pages]);
        }

        if ($act == "createStickFooterProcess") {
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('pagee', $_POST['pagee']);
                newRequest('page_children', $_POST['page_children']);
                newRequest('stick_footer_title', $_POST['stick_footer_title']);
                newRequest('stick_footer_link', $_POST['stick_footer_link']);
                newRequest('stick_footer_icon', $_POST['stick_footer_icon']);
                newRequest('stick_footer_text', $_POST['stick_footer_text']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $pagee = sanitizeInput($_POST['pagee']);
                    $page_children = sanitizeInput($_POST['page_children']);
                    $stick_footer_text = sanitizeInput($_POST['stick_footer_text']);
                    $stick_footer_icon = sanitizeInput($_POST['stick_footer_icon']);
                    $stick_footer_link = sanitizeInput($_POST['stick_footer_link']);
                    $stick_footer_title = sanitizeInput($_POST['stick_footer_title']);

                else:
                    $pagee = sanitizeInputNonEn($_POST['pagee']);
                    $page_children = sanitizeInputNonEn($_POST['page_children']);
                    $stick_footer_text = sanitizeInputNonEn($_POST['stick_footer_text']);
                    $stick_footer_icon = sanitizeInputNonEn($_POST['stick_footer_icon']);
                    $stick_footer_link = sanitizeInputNonEn($_POST['stick_footer_link']);
                    $stick_footer_title = sanitizeInputNonEn($_POST['stick_footer_title']);
                endif;

                if ($pagee == '') {
                    if ($this->language == 'en'):
                        setError('enter position value correctly');
                    elseif ($this->language == 'fa'):
                        setError('جایگاه را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل موضع بشكل صحيح');
                    endif;
                }

                $planable_type = [];
                foreach ($pagee as $item) {
                    if ($item == 1) {
                        $planable_type[] = "blog";
                    } elseif ($item == 2) {
                        $planable_type[] = "service";
                    } elseif ($item == 3) {
                        $planable_type[] = "service_sample";
                    } elseif ($item == 4) {
                        $planable_type[] = "news";
                    } elseif ($item == 5) {
                        $planable_type[] = "page";
                    } elseif ($item == 6) {
                        $planable_type[] = "index";
                    }elseif ($item == 7) {
                        $planable_type[] = "services";
                    }elseif ($item == 8) {
                        $planable_type[] = "blogs";
                    }elseif ($item == 9) {
                        $planable_type[] = "news";
                    }elseif ($item == 10) {
                        $planable_type[] = "sampleServices";
                    }
                }
                $planable_type = json_encode($planable_type);

                $planable_id = json_encode($page_children);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Setting-createStickFooter?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerStickFooterPages($planable_type, $planable_id,$stick_footer_text,$stick_footer_icon,$stick_footer_link,$stick_footer_title);
                    redirect('adminpanel/Plan-stickFooterList');
                }


            }
        }

        if($act=="stickFooterList"){
            $stickFooters=$this->getStickFooters();
            renderView("admin.$this->language.plan.list_stickFooter", ['stickFooters' => $stickFooters]);
        }

        if($act=="stickFooterDelete"){
            $stickFooterId=$option;
            $this->deleteStickFooter($stickFooterId);
            redirect('adminpanel/Setting-stickFooterList');
        }

        if($act=="editStickFooter"){
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $stickFooterId=$option;
            $stickFooter=$this->getStickFooter($stickFooterId)[0];
            renderView("admin.$this->language.plan.edit_stickFooter", ['stickFooter' => $stickFooter,'token' => $token, 'pages' => $this->pages]);

        }

        if($act=="editStickFooterProcess"){
            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);


                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($this->language == 'en'):
                    $pagee = sanitizeInput($_POST['pagee']);
                    $page_children = sanitizeInput($_POST['page_children']);
                    $stick_footer_text = sanitizeInput($_POST['stick_footer_text']);
                    $stick_footer_icon = sanitizeInput($_POST['stick_footer_icon']);
                    $stick_footer_link = sanitizeInput($_POST['stick_footer_link']);
                    $stick_footer_title = sanitizeInput($_POST['stick_footer_title']);

                else:
                    $pagee = sanitizeInputNonEn($_POST['pagee']);
                    $page_children = sanitizeInputNonEn($_POST['page_children']);
                    $stick_footer_text = sanitizeInputNonEn($_POST['stick_footer_text']);
                    $stick_footer_icon = sanitizeInputNonEn($_POST['stick_footer_icon']);
                    $stick_footer_link = sanitizeInputNonEn($_POST['stick_footer_link']);
                    $stick_footer_title = sanitizeInputNonEn($_POST['stick_footer_title']);
                endif;

                if ($pagee == '') {
                    if ($this->language == 'en'):
                        setError('enter position value correctly');
                    elseif ($this->language == 'fa'):
                        setError('جایگاه را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل موضع بشكل صحيح');
                    endif;
                }

                $planable_type = [];
                foreach ($pagee as $item) {
                    if ($item == 1) {
                        $planable_type[] = "blog";
                    } elseif ($item == 2) {
                        $planable_type[] = "service";
                    } elseif ($item == 3) {
                        $planable_type[] = "service_sample";
                    } elseif ($item == 4) {
                        $planable_type[] = "news";
                    } elseif ($item == 5) {
                        $planable_type[] = "page";
                    } elseif ($item == 6) {
                        $planable_type[] = "index";
                    }elseif ($item == 7) {
                        $planable_type[] = "services";
                    }elseif ($item == 8) {
                        $planable_type[] = "blogs";
                    }elseif ($item == 9) {
                        $planable_type[] = "news";
                    }elseif ($item == 10) {
                        $planable_type[] = "sampleServices";
                    }
                }
                $planable_type = json_encode($planable_type);

                $planable_id = json_encode($page_children);
                $stickFooterId=sanitizeInput($_POST['stickFooterId']);
                if (!empty(getErrors())) {
                    redirect('adminpanel/Setting-createStickFooter?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editStickFooterPages($stickFooterId,$planable_type, $planable_id,$stick_footer_text,$stick_footer_icon,$stick_footer_link,$stick_footer_title);
                    redirect('adminpanel/Plan-stickFooterList');
                }


            }
        }

    }

    private function registerPlanTime($title, $time_period, $title_value)
    {
        $data = [
            'period' => $time_period,
            'title' => $title,
            'value' => $title_value
        ];

        return $this->db->insert("plan_times", $data);
    }

    private function getTimes()
    {
        return $this->db->select_q("plan_times", [], 'order by id desc');
    }

    private function getTime($plan_time_id)
    {
        $data = [
            'id' => $plan_time_id
        ];
        return $this->db->select_q("plan_times", $data);
    }

    private function editPlanTime($time_id, $title, $time_period, $title_value)
    {
        $data = [
            'period' => $time_period,
            'title' => $title,
            'value' => $title_value
        ];

        return $this->db->update("plan_times", $data, "id='" . $time_id . "'");
    }

    private function deletePlanTime($time_id)
    {
        $query = "delete from `plan_times` where `id`='" . $time_id . "' limit 1";

        return $this->db->select_old($query);
    }

    private function getBlogs()
    {
        $query = "select `id`,`title` from `blogs` where `language`='" . $this->language . "' order by `id` desc";
        return $this->db->rawQuery($query);
    }

    private function getServices()
    {
        $query = "select `id`,`title` from `services` where `language`='" . $this->language . "' order by `id` desc";
        return $this->db->rawQuery($query);
//        return $this->db->select_q("services", ['language'=>$this->language], 'order by id desc');
    }

    private function getSampleServices()
    {
        $query = "select `id`,`title` from `sample_service` where `language`='" . $this->language . "' order by `id` desc";
        return $this->db->rawQuery($query);
//        return $this->db->select_q("sample_service", ['language'=>$this->language], 'order by id desc');
    }

    private function getNews()
    {
        $query = "select `id`,`title` from `news` where `language`='" . $this->language . "' order by `id` desc";
        return $this->db->rawQuery($query);
//        return $this->db->select_q("news", ['language'=>$this->language], 'order by id desc');
    }

    private function getPages()
    {
        $query = "select `id`,`title` from `pages` where `language`='" . $this->language . "' order by `id` desc";
        return $this->db->rawQuery($query);
//        return $this->db->select_q("pages", ['language'=>$this->language], 'order by id desc');
    }

    private function registerPlan($title, $time_period, $planable_type, $brief_description, $planable_id)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'time_period' => $time_period,
            'planable_id' => $planable_id,
            'planable_type' => $planable_type,
        ];

        return $this->db->insert("plans", $data);
    }

    private function getPlans()
    {
        $query = "select * from `plans` order by `id` desc";
        return $this->db->rawQuery($query);
    }

    private function deletePlan($plan_id)
    {
        $query = "delete from `plans` where `id`='" . $plan_id . "' limit 1";

        return $this->db->select_old($query);

    }

    private function getPlan($plan_id)
    {
        $query = "select * from plans where id='" . $plan_id . "'";
        return $this->db->rawQuery($query);
    }

    private function editPlan($plan_id, $title, $time_period, $planable_type, $brief_description, $planable_id)
    {
        $data = [
            'title' => $title,
            'brief_description' => $brief_description,
            'time_period' => $time_period,
            'planable_id' => $planable_id,
            'planable_type' => $planable_type,
        ];

        $this->db->update("plans", $data, 'id="' . $plan_id . '"');

        $plan_feature = $this->getPlanFeatureByPlan_id($plan_id)[0];
        $plan_feature_prices = $this->getPlanFeaturePrice($plan_feature)[0];

        $this->deletePlanFeatureByPlanFeatureId($plan_feature_prices['plan_feature_id']);
        $this->updatePlanFeaturePriceTimePeriod($plan_feature_prices['plan_feature_id'], json_decode($time_period));

    }

    private function registerPlanFeature($title, $brief_description, $plan, $positive_features, $negative_features, $icon)
    {
        $data = [
            'plan_id' => $plan,
            'title' => $title,
            'brief_description' => $brief_description,
            'icon' => $icon,
            'positive_features' => $positive_features,
            'negative_features' => $negative_features,
        ];


        $plan_feature_id = $this->db->insert("plan_features", $data);
        $times = json_decode(($this->getPlan($plan)[0])['time_period']);
        foreach ($times as $time) {
            $data1 = [
                'plan_feature_id' => $plan_feature_id,
                'time_period_id' => $time
            ];
            $this->db->insert("plan_feature_price", $data1);
        }

        return true;
    }

    private function getPlanFeatures()
    {
        return $this->db->select_q("plan_features", [], 'order by id desc');
    }

    private function getPlanFeature($feature_id)
    {
        $data = [
            'id' => $feature_id
        ];
        return $this->db->select_q("plan_features", $data);
    }

    private function getPlanFeatureByPlan_id($plan_id)
    {
        $data = [
            'plan_id' => $plan_id
        ];
        return $this->db->select_q("plan_features", $data);
    }

    private function getPlanFeaturePrice($plan_feature)
    {
        $data = [
            'plan_feature_id' => $plan_feature
        ];

        return $this->db->select_q("plan_feature_price", $data);
    }

    private function deletePlanFeatureByPlanFeatureId($val)
    {
        $query = "delete from plan_feature_price where plan_feature_id='" . $val . "' limit 1";

        return $this->db->select_old($query);
    }

    private function updatePlanFeaturePriceTimePeriod($plan_feature_id, $timePeriod)
    {
        foreach ($timePeriod as $time) {
            $data1 = [
                'plan_feature_id' => $plan_feature_id,
                'time_period_id' => $time
            ];
            $this->db->insert("plan_feature_price", $data1);
        }
    }

    private function checkIfPlanExist($planable_type, $page_children)
    {
        $data = [
            'planable_id' => $page_children,
            'planable_type' => $planable_type,
        ];

        return $this->db->select_q("plans", $data);
    }

    private function checkIfSubPlanExist($plan)
    {
        $data = [
            'plan_id' => $plan
        ];

        return $this->db->select_q("plan_features", $data);
    }

    private function getPlanFeaturePrices()
    {
        return $this->db->select_q("plan_feature_price", [], 'order by id desc');
    }

    private function updatePlanPrice($id, $price)
    {
        $data = [
            'price' => $price
        ];

        return $this->db->update("plan_feature_price", $data, 'id="' . $id . '"');
    }

    private function getPlanFeaturePricesById($planFeaturePriceId)
    {
        return $this->db->select_q("plan_feature_price", ['id' => $planFeaturePriceId], 'order by id desc');
    }

    private function deletePlanFeaturePrice($planFeaturePriceId)
    {
        $query = "delete from plan_feature_price where id='" . $planFeaturePriceId . "' limit 1";

        return $this->db->select_old($query);
    }

    private function deletePlanFeaturePriceByPlanFeatureId($planFeatureId)
    {
        $query = "delete from plan_feature_price where plan_feature_id='" . $planFeatureId . "' ";

        return $this->db->select_old($query);
    }

    private function deletePlanFeature($plan_feature_id)
    {
        $query = "delete from plan_features where id='" . $plan_feature_id . "' limit 1";

        return $this->db->select_old($query);
    }

    private function getPlanFeaturePricesByFeatureId($plan_feature_id)
    {
        return $this->db->select_q("plan_feature_price", ['plan_feature_id' => $plan_feature_id], 'order by id desc');
    }

    private function editPlanFeature($plan_feature_id, $title, $brief_description, $plan, $positive_features, $negative_features, $icon)
    {

        $data = [
            'plan_id' => $plan,
            'title' => $title,
            'brief_description' => $brief_description,
            'icon' => $icon,
            'positive_features' => $positive_features,
            'negative_features' => $negative_features,
        ];


        $this->db->update("plan_features", $data, "id='" . $plan_feature_id . "'");
        $times = json_decode(($this->getPlan($plan)[0])['time_period']);
        $this->deletePlanFeaturePriceByPlanFeatureId($plan_feature_id);
        foreach ($times as $time) {
            $data1 = [
                'plan_feature_id' => $plan_feature_id,
                'time_period_id' => $time
            ];

            $this->db->insert("plan_feature_price", $data1);
        }

        return true;
    }

    private function updatePlanFeaturePriceParticular($situation, $plan_feature_price_id)
    {
        $data = [
            'particular' => $situation
        ];

        return $this->db->update("plan_feature_price", $data, "id='" . $plan_feature_price_id . "'");
    }

    private function registerStickFooterPages( $planable_type, $planable_id, $stick_footer_text, $stick_footer_icon,$stick_footer_link, $stick_footer_title)
    {
        $data=[
            'pageable_type'=>$planable_type,
            'pageable_id'=>$planable_id,
            'stick_footer_text'=>$stick_footer_text,
            'stick_footer_icon'=>$stick_footer_icon,
            'stick_footer_link'=>$stick_footer_link,
            'stick_footer_title'=>$stick_footer_title
        ];

        return $this->db->insert("stick_footer_pages",$data);
    }

    private function getStickFooters()
    {

        return $this->db->select_q("stick_footer_pages",[],'order by id desc');
    }

    private function deleteStickFooter( $stickFooterId)
    {
        $query="delete from stick_footer_pages where id='".$stickFooterId."' limit 1 ";

        return $this->db->select_old($query);
    }

    private function getStickFooter( $stickFooterId)
    {
        return $this->db->select_q("stick_footer_pages",['id'=>$stickFooterId]);
    }

    private function editStickFooterPages($stickFooterId,$planable_type,$planable_id,$stick_footer_text, $stick_footer_icon,$stick_footer_link,$stick_footer_title)
    {
        $data=[
            'pageable_type'=>$planable_type,
            'pageable_id'=>$planable_id,
            'stick_footer_text'=>$stick_footer_text,
            'stick_footer_icon'=>$stick_footer_icon,
            'stick_footer_link'=>$stick_footer_link,
            'stick_footer_title'=>$stick_footer_title
        ];

        return $this->db->update("stick_footer_pages",$data,'id="'.$stickFooterId.'"');
    }

}