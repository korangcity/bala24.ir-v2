<?php


use App\controller\Auth;
use App\controller\home\Company;
use App\controller\home\Service;
use App\controller\home\Setting;
use App\controller\Instagram;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

use GuzzleHttp\Client;
use Jenssegers\Blade\Blade;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use  Rakit\Validation\Validator;

function view(array $route)
{
    $sessionProvider = new EasyCSRF\NativeSessionProvider();
    $easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);
    $phraseBuilder = new PhraseBuilder(5, '0123456789');
    $builder = new CaptchaBuilder(null, $phraseBuilder);


    if ($route['page_for'] == 'guest') {

        $language=getLanguage();

        if ($route['TheCourse'] == 'home') {

            $service_obj = new Service();
            destroyErrors();
            requestSessionDestroy();
            if ($_REQUEST['verify'] == true) {
                destroyRegisterMessageOk();
                redirect(substr($_SERVER['REQUEST_URI'], 1, strpos($_SERVER['REQUEST_URI'], "?") - 1));
            }

            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                newRequest('name', $_POST['name']);
                newRequest('email', $_POST['email']);
                newRequest('subject', $_POST['subject']);
                newRequest('message', $_POST['message']);

                $checkCsrf = $service_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }

                $name = sanitizeInputNonEn($_POST['name']);
                $email = sanitizeInputNonEn($_POST['email']);
                $subject = sanitizeInputNonEn($_POST['subject']);
                $message = sanitizeInputNonEn($_POST['message']);


                if (!$name) {
                    setError(' نام و نام خانوادگی را به درستی وارد کنید');
                }
                if (!$subject) {
                    setError(' موضوع را به درستی وارد کنید');
                }

                if(!emailVerify($email)){
                    setError(' ایمیل را به درستی وارد کنید');
                }

                if (!$message) {
                    setError(' پیام را به درستی وارد کنید');
                }

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $service_obj->registerMessage($name, $email,$subject, $message);
                    destroyErrorCheck();
                    setRegisterMessageOk();
                    back();
                }


            }



            $services=$service_obj->getServices();
            $company=new Company();
            $companies=$company->companies();
            $khadamats=$service_obj->getKhadamats();
            $getSecurityCode=$service_obj->getSecurityCodes();
            $set=new Setting();
            $setting=$set->settingInfo()[0];

            $plan=$service_obj->getPlan('i');

            renderView('home.'.$language.'.main.index', ['plan'=>$plan,'builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'],'khadamats'=>$khadamats,'services'=>$services,"setting"=>$setting,"companies"=>$companies]);
        }

        if ($route['TheCourse'] == "service") {

            $service_obj = new Service();
            $service = $service_obj->getService($route['main'])[0];
            $service_category=$service_obj->getServiceCategory($service['category_id'])[0];
            $serviceProcess=$service_obj->getServiceGuides($service['id']);
            $sampleServices=$service_obj->getSampleServices($service['id']);
            $serviceParts=$service_obj->getServiceParts($service['id']);
            $plan=$service_obj->getPlan($service['id']);
            $subPlans=$service_obj->getSubPlan($plan['id']);
            $time_periods=$service_obj->getTimePeriods();

            renderView('home.'.$language.'.service.single', ['service_obj' => $service_obj,'subPlans' => $subPlans,'time_periods' => $time_periods,'plan' => $plan,'main_url' => $route['main'],'serviceParts' => $serviceParts,'sampleServices' => $sampleServices,'serviceProcess' => $serviceProcess,'service' => $service,"service_category"=>$service_category]);

        }

        if($route['TheCourse']=="sampleService"){

            $service_obj = new Service();
            $sampleService = $service_obj->getSampleService($route['single'])[0];
            renderView('home.'.$language.'.service.sample_service', ['sampleService' => $sampleService]);

        }


    } elseif ($route['page_for'] == 'sitemap') {

    } elseif ($route['page_for'] == 'admin') {


    }
}