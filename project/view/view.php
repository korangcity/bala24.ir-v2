<?php


use App\controller\DTC;
use App\controller\home\Auth;
use App\controller\home\Blog;
use App\controller\home\Company;
use App\controller\home\FAQ;
use App\controller\home\Index;
use App\controller\home\Metatag;
use App\controller\home\Page;
use App\controller\home\Service;
use App\controller\home\Setting;
use App\controller\home\Slider;
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
    $dtc_obj = new DTC();

    if ($route['page_for'] == 'guest') {

        $language = getLanguage();

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

                if (!emailVerify($email)) {
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
                    $service_obj->registerMessage($name, $email, $subject, $message);
                    destroyErrorCheck();
                    setRegisterMessageOk();
                    back();
                }


            }


            $services = $service_obj->getServices();
            $company = new Company();
            $index = new Index();
            $companies = $company->companies();
            $khadamats = $index->getKhadamatsIndex("i");
            $getSecurityCode = $service_obj->getSecurityCodes();
            $set = new Setting();
            $setting = $set->settingInfo()[0];

            $plan = $index->getPlanIndex('i');
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $stickFooter = $index->getStickFooterIndex("i");
            $video = $index->getVideoIndex("i");
            $serviceCategory = $service_obj->getServiceCategory($video['service_category_id'])[0]['title'];
            $time_periods = $service_obj->getTimePeriods();
            $sldr = new Slider();
            $slider = $sldr->getSlider()[0];
            $meta = new Metatag();
            $metatag = $meta->getMetatag("/")[0];


            renderView('home.' . $language . '.main.index', ['metatag' => $metatag, 'serviceCategory' => $serviceCategory, 'video' => $video, 'slider' => $slider, 'time_periods' => $time_periods, 'subPlans' => $subPlans, 'stickFooter' => $stickFooter, 'plan' => $plan, 'builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], 'khadamats' => $khadamats, 'services' => $services, "setting" => $setting, "companies" => $companies]);
        }

        if ($route['TheCourse'] == "service") {

            $service_obj = new Service();
            $service = $service_obj->getService($route['single'])[0];
            $service_category = $service_obj->getServiceCategory($service['category_id'])[0];
            $serviceProcess = $service_obj->getServiceGuides($service['id']);
            $sampleServices = $service_obj->getSampleServices($service['id']);
            $serviceParts = $service_obj->getServiceParts($service['id']);
            $plan = $service_obj->getPlan($service['id']);
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $video = $service_obj->getVideo($service['id']);
            $serviceCategory = $service_obj->getServiceCategory($video['service_category_id'])[0]['title'];
            $time_periods = $service_obj->getTimePeriods();
            $stickFooter = $service_obj->getStickFooter($service['id']);
            $khadamats = $service_obj->getKhadamats($service['id']);

            renderView('home.' . $language . '.service.single', ['khadamats' => $khadamats, 'stickFooter' => $stickFooter, 'serviceCategory' => $serviceCategory, 'video' => $video, 'service_obj' => $service_obj, 'subPlans' => $subPlans, 'time_periods' => $time_periods, 'plan' => $plan, 'main_url' => $route['single'], 'serviceParts' => $serviceParts, 'sampleServices' => $sampleServices, 'serviceProcess' => $serviceProcess, 'service' => $service, "service_category" => $service_category]);

        }

        if ($route['TheCourse'] == "search") {
            renderView('home.' . $language . '.result.index', []);

        }

        if ($route['TheCourse'] == "blog") {

            $service_obj = new Service();
            $blog_obj = new Blog();
            $blog = $blog_obj->getBlog($route['single'])[0];
            $blog_category = $blog_obj->getBlogCategory($blog['category_id'])[0];
            $blogs_in_category = $blog_obj->getBlogInCategory($blog['id'],$blog['category_id']);

            $author = $blog['author'];
            $authorPaperNumber = $blog_obj->getAuthorPaperNumber($author)[0]["Author"];
            $otherAuthors = $blog_obj->getOtherAuthors($author);

            $authorsArray = [];
            foreach ($otherAuthors as $otherAuthor) {
                $authorsArray[] = $blog_obj->getAuthorName($otherAuthor["author"])[0];
            }


            $plan = $blog_obj->getPlan($blog['id']);
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $video = $blog_obj->getVideo($blog['id']);
            $time_periods = $service_obj->getTimePeriods();
            $stickFooter = $blog_obj->getStickFooter($blog['id']);
            $khadamats = $blog_obj->getKhadamats($service['id']);
            renderView('home.' . $language . '.blog.single', ['authorsArray' => $authorsArray, 'authorPaperNumber' => $authorPaperNumber, 'khadamats' => $khadamats, 'stickFooter' => $stickFooter, 'blog_category' => $blog_category, 'video' => $video, 'service_obj' => $service_obj, 'subPlans' => $subPlans, 'time_periods' => $time_periods, 'plan' => $plan, 'blog' => $blog,'blogs_in_category'=>$blogs_in_category]);

        }

        if ($route['TheCourse'] == "services") {

            $service_obj = new Service();
            $services = $service_obj->getServices();

            $khadamats = $service_obj->getKhadamats2("s");
            $plan = $service_obj->getPlan2('s');
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $stickFooter = $service_obj->getStickFooter2("s");
            $video = $service_obj->getVideo2("s");
            $serviceCategory = $service_obj->getServiceCategory($video['service_category_id'])[0]['title'];
            $time_periods = $service_obj->getTimePeriods();

            $meta = new Metatag();
            $metatag = $meta->getMetatag("/services")[0];

            renderView('home.' . $language . '.service.index', ['metatag' => $metatag, 'services' => $services, 'video' => $video, 'service_obj' => $service_obj, 'subPlans' => $subPlans, 'time_periods' => $time_periods, 'plan' => $plan]);

        }

        if ($route['TheCourse'] == "sampleService") {

            $service_obj = new Service();
            $sampleService = $service_obj->getSampleService($route['single'])[0];
            $getSecurityCode = $service_obj->getSecurityCodes();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            $plan = $service_obj->getPlanSample($sampleService['id']);
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $khadamats = $service_obj->getKhadamatsSample($sampleService['id']);
            $stickFooter = $service_obj->getStickFooterSample($sampleService['id']);
            $video = $service_obj->getVideoSample($sampleService['id']);
            $serviceCategory = $service_obj->getServiceCategory($video['service_category_id'])[0]['title'];
            $time_periods = $service_obj->getTimePeriods();
            renderView('home.' . $language . '.service.sample_service', ['serviceCategory' => $serviceCategory, 'video' => $video, 'time_periods' => $time_periods, 'subPlans' => $subPlans, 'khadamats' => $khadamats, 'stickFooter' => $stickFooter, 'plan' => $plan, 'service_obj' => $service_obj, 'sampleService' => $sampleService]);

        }

        if ($route['TheCourse'] == "signup") {
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                newRequest('mobile', $_POST['mobile']);
                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }
                $mobile = sanitizeInput($_POST['mobile']);

                if (!checkIfMobileIsCorrect($mobile)) {
                    setError(' شماره موبایل را به درستی وارد کنید');
                }

                if (!empty($auth_obj->checkUserExist($mobile)[0])) {
                    setError(' شما قبلا ثبت نام کرده اید');
                }

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $info1 = $auth_obj->register($mobile);
                    destroyErrorCheck();
                    $info = [
                        'user_id' => $dtc_obj->enc($info1['user_id']),
                        'user_code' => $dtc_obj->enc($info1['user_code'])
                    ];
                    setUserEncryptInfo($info);

                    redirect("two-step-verification");
                }

            } else {
                if (checkUserLogin()) {
                    redirect("");
                    die();
                }
                $getSecurityCode = $auth_obj->getSecurityCodes();
                setHttpRefrer();
                renderView('home.' . $language . '.auth.signup', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'],"setting"=>$setting]);

            }

        }

        if ($route['TheCourse'] == "two-step-verification") {
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                $user_id = getUserEncryptInfo()['user_id'];
                $client_sent_user_id = sanitizeInputNonEn($_POST['user_id']);

                if ($user_id != $client_sent_user_id) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                $user_code = $dtc_obj->dec(getUserEncryptInfo()['user_code']);
                $client_sent_user_code = sanitizeInput($_POST['digit4']) . sanitizeInput($_POST['digit3']) . sanitizeInput($_POST['digit2']) . sanitizeInput($_POST['digit1']);

                if ($user_code != $client_sent_user_code) {
                    setError('کد را به درستی ارسال کنید');
                }


                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    destroyErrorCheck();
                    redirect("user-complete-information");
                }

            } else {
                $getSecurityCode = $auth_obj->getSecurityCodes();
                $user_id = getUserEncryptInfo()['user_id'];

                $user_code = $dtc_obj->dec(getUserEncryptInfo()['user_code']);
                renderView('home.' . $language . '.auth.two_step_verification', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], 'user_id' => $user_id, 'user_code' => $user_code, 'setting' => $setting]);

            }

        }

        if ($route['TheCourse'] == "user-complete-information") {
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                newRequest('name', $_POST['name']);
                newRequest('email', $_POST['email']);

                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }
                $name = sanitizeInputNonEn($_POST['name']);
                $email = sanitizeInput($_POST['email']);
                $user_id = sanitizeInputNonEn($_POST['user_id']);
                $password = sanitizeInputNonEn($_POST['password']);
                $password = $dtc_obj->create_checksum($password);
                if (preg_match('[0-9@_!#$%^&*()<>?/|}{~:]', $name)) {
                    setError(' نام را به درستی وارد کنید');
                }

                if ($email != '' and !emailVerify($email)) {
                    setError(' ایمیل را صحیح وارد کنید');
                }

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $user_id = $dtc_obj->dec($user_id);
                    $auth_obj->updateUserInfo($user_id, $name, $email, $password);
                    userLogin();
                    getHttpRefere()!=""?redirectUrlComplete(getHttpRefere()):redirect("");
                    destroyHttpRefere();
                }


            } else {
                $getSecurityCode = $auth_obj->getSecurityCodes();
                $user_id = getUserEncryptInfo()['user_id'];
                renderView('home.' . $language . '.auth.user-complete-information', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], 'user_id' => $user_id, 'setting' => $setting]);

            }

        }

        if ($route['TheCourse'] == "signin") {
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];

            if ($_POST) {

                destroyErrors();
                requestSessionDestroy();

                newRequest('mobile', $_POST['mobile']);
                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }
                $mobile = sanitizeInput($_POST['mobile']);
                $password = sanitizeInputNonEn($_POST['password']);

                if (!checkIfMobileIsCorrect($mobile)) {
                    setError(' شماره موبایل را به درستی وارد کنید');
                }

                if (empty($auth_obj->checkUserExist($mobile)[0])) {
                    setError(' اطلاعات شما موجود نمیباشد');
                }

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $infoo = $auth_obj->signin($mobile, $password);

                    if ($infoo[0]) {
                        userLogin();
                        setUserEncryptInfo(['user_id' => $dtc_obj->enc($infoo[1])]);
                        getHttpRefere()!=""?redirectUrlComplete(getHttpRefere()):redirect("");
                        destroyHttpRefere();
                    } else {
                        setError(' پسورد وارد شده اشتباه میباشد');
                    }

                    if (!empty(getErrors())) {
                        back();
                        setErrorCheck();
                    }

                }
            } else {
                if (checkUserLogin()) {
                    redirectUrlComplete(getHttpRefere());
                    destroyHttpRefere();
                    die();
                }
                $getSecurityCode = $auth_obj->getSecurityCodes();
                setHttpRefrer();

                renderView('home.' . $language . '.auth.signin', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'],"setting"=>$setting]);
            }

        }

        if($route['TheCourse'] == "signout"){

            setHttpRefrer();
            userLogout();
            destroyUserEncryptInfo();
            getHttpRefere()!=""?redirectUrlComplete(getHttpRefere()):redirect("");
            destroyHttpRefere();

        }

        if($route['TheCourse'] == "faq"){
            $faq_obj=new FAQ();
            $faq_constant=$faq_obj->getFaqConstant()[0];
            $faqs=$faq_obj->getFaqs();
            renderView('home.' . $language . '.faq.index', ['faq_constant'=>$faq_constant,'faqs'=>$faqs]);
        }

        if($route['TheCourse'] == "forgot-password"){
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                newRequest('mobile', $_POST['mobile']);
                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }
                $mobile = sanitizeInput($_POST['mobile']);

                if (!checkIfMobileIsCorrect($mobile)) {
                    setError(' شماره موبایل را به درستی وارد کنید');
                }

                if (empty($auth_obj->checkUserExist($mobile)[0])) {
                    setError(' اکانتی با شماره موبایل مورد نظر موجود نیست');
                }

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $info1= $auth_obj->sendForgotPasswordCode($mobile);
                    destroyErrorCheck();
                    $info = [
                        'user_mobile' => $mobile,
                        'user_code' => $dtc_obj->enc($info1['user_code'])
                    ];
                    setUserEncryptInfo1($info);

                    redirect("two-step-verification-forgot-password");
                }

            } else {
                if (checkUserLogin()) {
                    redirect("");
                    die();
                }
                $getSecurityCode = $auth_obj->getSecurityCodes();
                renderView('home.' . $language . '.auth.forgot-password', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'],"setting"=>$setting]);

            }

        }

        if($route['TheCourse'] == "two-step-verification-forgot-password"){
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                $user_mobile = getUserEncryptInfo1()['user_mobile'];
                $client_sent_user_mobile = sanitizeInput($_POST['user_mobile']);

                if ($user_mobile != $client_sent_user_mobile) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }

                $user_code = $dtc_obj->dec(getUserEncryptInfo1()['user_code']);
                $client_sent_user_code = sanitizeInput($_POST['digit4']) . sanitizeInput($_POST['digit3']) . sanitizeInput($_POST['digit2']) . sanitizeInput($_POST['digit1']);

                if ($user_code != $client_sent_user_code) {
                    setError('کد را به درستی ارسال کنید');
                }


                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    destroyErrorCheck();
                    redirect("user-create-new-password");
                }

            } else {
                $getSecurityCode = $auth_obj->getSecurityCodes();
                $user_mobile = getUserEncryptInfo1()['user_mobile'];

                $user_code = $dtc_obj->dec(getUserEncryptInfo1()['user_code']);
                renderView('home.' . $language . '.auth.two_step_verification_forgot_password', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], 'user_mobile' => $user_mobile, 'user_code' => $user_code, 'setting' => $setting]);

            }
        }

        if($route['TheCourse'] == "user-create-new-password"){
            $auth_obj = new Auth();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $auth_obj->checkCsrf();

                if ($checkCsrf === false) {
                    setError('اطلاعات را به درستی ارسال کنید');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError(' کد را به درستی وارد کنید');

                }

                $user_mobile = sanitizeInputNonEn($_POST['user_mobile']);
                $password = sanitizeInputNonEn($_POST['password']);
                $password_confirm = sanitizeInputNonEn($_POST['password_confirm']);

                if($password!==$password_confirm){
                    setError(' رمز جدید و تایید رمیز جدید بکسان نیستند');
                }

                $password = $dtc_obj->create_checksum($password);

                if (!empty(getErrors())) {
                    back();
                    setErrorCheck();
                }

                if (empty(getErrors())) {
                    $user_mobile = $user_mobile;
                    $auth_obj->updateUserPassword($user_mobile,$password);
                    redirect("/signin?status=true");
                }


            } else {
                $getSecurityCode = $auth_obj->getSecurityCodes();
                $user_mobile = getUserEncryptInfo1()['user_mobile'];
                renderView('home.' . $language . '.auth.user-create-new-password', ['builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], 'user_mobile' => $user_mobile, 'setting' => $setting]);

            }

        }

        if (explode("/", $route['TheCourse'])[0] == "page") {
            $urll = explode("/", $route['TheCourse'])[1];
            $pg = new Page();
            $page = $pg->getPage($urll)[0];
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

                if (!emailVerify($email)) {
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
                    $service_obj->registerMessage($name, $email, $subject, $message);
                    destroyErrorCheck();
                    setRegisterMessageOk();
                    back();
                }


            }


            $getSecurityCode = $service_obj->getSecurityCodes();
            $set = new Setting();
            $setting = $set->settingInfo()[0];
            $plan = $pg->getPlanPage($page['id']);
            $subPlans = $service_obj->getSubPlan($plan['id']);
            $khadamats = $pg->getKhadamatsPage($page['id']);
            $stickFooter = $pg->getStickFooterPage($page['id']);
            $video = $pg->getVideoPage($page['id']);
            $serviceCategory = $service_obj->getServiceCategory($video['service_category_id'])[0]['title'];
            $time_periods = $service_obj->getTimePeriods();
            renderView('home.' . $language . '.page.index', ['serviceCategory' => $serviceCategory, 'video' => $video, 'time_periods' => $time_periods, 'service_obj' => $service_obj, 'subPlans' => $subPlans, 'khadamats' => $khadamats, 'stickFooter' => $stickFooter, 'plan' => $plan, 'main_url' => $urll, 'page' => $page, 'builder' => $getSecurityCode['builder'], 'token' => $getSecurityCode['token'], "setting" => $setting]);
        }

    } elseif ($route['page_for'] == 'sitemap') {

    } elseif ($route['page_for'] == 'admin') {


    }
}