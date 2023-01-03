<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Morilog\Jalali\CalendarUtils;
 
class Auth
{
    private $db;
    private $sessionProvider;
    private $easyCSRF;
    private $phraseBuilder;
    private $builder;
    private $language;


    public function __construct()
    {
        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();
    }

    public function act($act, $option = '')
    {
        if ($act == "signup") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.auth.signup", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "signupProcess") {

            if ($_POST) {
                if (!isset($_REQUEST['error'])) {
                    destroyErrors();
                    requestSessionDestroy();
                }

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('email', $_POST['email']);

                if ($checkCsrf === false) {
                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    if ($this->language == 'en'):
                        setError('enter captcha value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار کپچا را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل کلمة تحقیق بشكل صحيح');
                    endif;
                }

                $email = sanitizeInput($_POST['email']);
                $password = sanitizeInput($_POST['password']);
                $confirm_password = sanitizeInput($_POST['confirm_password']);

                if (!emailVerify($email) or $email == '') {
                    if ($this->language == 'en'):
                        setError('enter email value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار ایمیل را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل البريد الإلكتروني بشكل صحيح');
                    endif;
                }

                if (strlen($password) < 4 or $password == '') {
                    if ($this->language == 'en'):
                        setError('length of password must be atleast 4 characters');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول پسورد حداقل 4 کاراکتر میباشد');
                    elseif ($this->language == 'ar'):
                        setError('يجب ألا يقل طول كلمة المرور عن 4 أحرف');
                    endif;
                }

                if (strlen($confirm_password) < 4 or $confirm_password == '' or $password != $confirm_password) {
                    if ($this->language == 'en'):
                        setError('password and confirmed password must be the same');
                    elseif ($this->language == 'fa'):
                        setError('پسورد و تایید پسورد باید یکسان باشد');
                    elseif ($this->language == 'ar'):
                        setError('يجب أن تكون كلمة المرور وكلمة المرور المؤكدة متطابقتين');
                    endif;
                }

                if (empty(getErrors())) {
                    if (is_array($this->checkIfUserIsSignedup($email)[0])):
                        if ($this->language == 'en'):
                            setError('you have an account');
                        elseif ($this->language == 'fa'):
                            setError('شما اکانت دارید');
                        elseif ($this->language == 'ar'):
                            setError('لديك حساب');
                        endif;

                    endif;
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Auth-signup?error=true');
                }

                if (empty(getErrors())) {
                    $password = sha1($password);
                    $r = $this->register($email, $password);
                    redirect('adminpanel/Auth-signin');
                }

            }

        }

        if ($act == "signin") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.auth.signin", ['token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "signinProcess") {
            if ($_POST) {
                if (!isset($_REQUEST['error'])) {
                    destroyErrors();
                    requestSessionDestroy();
                }

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);

                newRequest('email', $_POST['email']);
                if ($checkCsrf === false) {
                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    if ($this->language == 'en'):
                        setError('enter captcha value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار کپچا را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل کلمة تحقیق بشكل صحيح');
                    endif;
                }

                $email = sanitizeInput($_POST['email']);
                $password = sanitizeInput($_POST['password']);

                if (!emailVerify($email) or $email == '') {
                    if ($this->language == 'en'):
                        setError('enter email value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار ایمیل را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل البريد الإلكتروني بشكل صحيح');
                    endif;
                }

                if (strlen($password) < 4 or $password == '') {
                    if ($this->language == 'en'):
                        setError('length of password must be atleast 4 characters');
                    elseif ($this->language == 'fa'):
                        setError('حداقل طول پسورد حداقل 4 کاراکتر میباشد');
                    elseif ($this->language == 'ar'):
                        setError('يجب ألا يقل طول كلمة المرور عن 4 أحرف');
                    endif;
                }

                if (!empty(getErrors())) {
                    redirect('adminpanel/Auth-signin?error=true');
                }

                if (empty(getErrors())) {
                    $password = sha1($password);

                    $result = $this->signin($email, $password);
                    if ($result == false):
                        if ($this->language == 'en'):
                            setError('user not found');
                        elseif ($this->language == 'fa'):
                            setError('کاربر یافت نشد');
                        elseif ($this->language == 'ar'):
                            setError('المستخدم ليس موجود');
                        endif;

                        redirect('adminpanel/Auth-signin?error=true');
                    else:
                        if (isset($_POST['remember_me'])) {
                            set_cookie('email', $_POST['email'], envv('ONE_MONTH'));
                            set_cookie('password', $_POST['password'], envv('ONE_MONTH'));
                            set_cookie('login', 1, envv('ONE_MONTH'));
                        }
                        login();
                        set_user_info($email, $password);
                        redirect('adminpanel/Dashboard-dashboard');
                    endif;
                }

            }
        }

        if ($act == "adminList") {
            $users = $this->users();
            renderView("admin.$this->language.auth.list", ['users' => $users]);
        }

        if ($act == "getUserInfoEn") {
            $user_id = sanitizeInput($_POST['user_id']);
            $user_info = $this->user($user_id)[0];
            $result = "";
            if ($user_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">civilization_code</th>';
                $result .= '<td>' . ($user_info["civilization_code"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">iban</th>';
                $result .= '<td>' . ($user_info["iban"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">credit_card_number</th>';
                $result .= '<td>' . ($user_info["credit_card_number"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">is_ban</th>';
                $result .= '<td>' . ($user_info["is_ban"] ? "Yes" : "No") . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">avatar</th>';
                $result .= '<td><img style="width:30%" src="' . ($user_info["avatar"] ? (baseUrl(httpCheck()) . $user_info["avatar"]) : '') . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">created_at</th>';
                $result .= '<td>' . ($user_info["created_at"] ?? '---') . '</td>';
                $result .= "</tr>";

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getUserInfoFa") {
            $user_id = sanitizeInput($_POST['user_id']);
            $user_info = $this->user($user_id)[0];
            $result = "";
            if ($user_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">کد ملی</th>';
                $result .= '<td>' . ($user_info["civilization_code"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">شماره شبا</th>';
                $result .= '<td>' . ($user_info["iban"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">شماره کارت بانکی</th>';
                $result .= '<td>' . ($user_info["credit_card_number"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">محدودیت</th>';
                $result .= '<td>' . ($user_info["is_ban"] == 1 ? "بله" : "خیر") . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">تصویر پروفایل</th>';
                $result .= '<td><img style="width:30%" src="' . ($user_info["avatar"] ? (baseUrl(httpCheck()) . $user_info["avatar"]) : '') . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">تاریخ ثبت</th>';
                $result .= '<td>' . ($user_info["created_at_jalali"] ?? '---') . '</td>';
                $result .= "</tr>";

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "getUserInfoAr") {
            $user_id = sanitizeInput($_POST['user_id']);
            $user_info = $this->user($user_id)[0];
            $result = "";
            if ($user_info) {

                $result .= "<tbody>";
                $result .= "<tr>";
                $result .= '<th scope="row">رمز دولي</th>';
                $result .= '<td>' . ($user_info["civilization_code"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">رقم شبعا</th>';
                $result .= '<td>' . ($user_info["iban"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">رقم البطاقة المصرفية</th>';
                $result .= '<td>' . ($user_info["credit_card_number"] ?? '---') . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">التقييد</th>';
                $result .= '<td>' . ($user_info["is_ban"] ? "نعم" : "لا") . '</td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">الصوره الشخصيه</th>';
                $result .= '<td><img style="width:30%" src="' . ($user_info["avatar"] ? (baseUrl(httpCheck()) . $user_info["avatar"]) : '') . '" alt=""></td>';
                $result .= "</tr>";
                $result .= "<tr>";
                $result .= '<th scope="row">تاريخ التسجيل</th>';
                $result .= '<td>' . ($user_info["created_at"] ?? '---') . '</td>';
                $result .= "</tr>";

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "changeUserSituation") {
            $user_id = sanitizeInput($_POST['user_id']);
            $situation = sanitizeInput($_POST['situation']);

            $this->updateUserSituation($user_id, $situation);
            echo true;

        }

        if ($act == "banUser") {
            $user_id = sanitizeInput($_POST['user_id']);
            $situation = sanitizeInput($_POST['situation']);

            $this->banUser($user_id, $situation);
            echo true;

        }

        if ($act == "deleteAdmin") {
            $user_id = $option;
            $user_info = $this->user($user_id)[0];
            if ($user_info['avatar']) {
                destroy_file($user_info['avatar']);
            }

            $this->deleteUser($user_id);
            redirect("adminpanel/Auth-adminList?success=true");

        }

        if ($act == "adminEdit") {
            $user_id = $option;
            $user_info = $this->user($user_id)[0];
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            renderView("admin.$this->language.auth.edit", ['user' => $user_info, 'token' => $token, 'builder' => $this->builder]);
        }

        if ($act == "adminEditProcess") {

            if ($_POST) {
                if (!isset($_REQUEST['error'])) {
                    destroyErrors();
                    requestSessionDestroy();
                }

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

                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    if ($this->language == 'en'):
                        setError('enter captcha value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار کپچا را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل کلمة تحقیق بشكل صحيح');
                    endif;
                }

                if ($this->language == "en") {
                    $name = sanitizeInput($_POST['name']);
                } else {
                    $name = sanitizeInputNonEn($_POST['name']);
                }
                $user_id = sanitizeInput($_POST['user_id']);
                $mobile = sanitizeInput($_POST['mobile']);
                $civilization_code = sanitizeInput($_POST['civilization_code']);
                $iban = sanitizeInput($_POST['iban']);
                $credit_card_number = sanitizeInput($_POST['credit_card_number']);

                if ($mobile != "" and !checkIfMobileIsCorrect($mobile)) {
                    if ($this->language == 'en'):
                        setError('enter mobile correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار موبایل را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل الجوال بشكل صحيح');
                    endif;
                }

                if ($iban != "" and !checkIfIbanIsCorrect($iban)) {
                    if ($this->language == 'en'):
                        setError('enter Shaba number correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار شماره شبا را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل رقم شبعا بشكل صحيح');
                    endif;
                }

                if ($credit_card_number != "" and !checkIfBankCardNumberIsCorrect($credit_card_number)) {
                    if ($this->language == 'en'):
                        setError('enter card number correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار شماره کارت را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل رقم البطاقة بشكل صحيح');
                    endif;
                }

                if ($civilization_code != "" and !checkIfCivilizationCodeIsCorrect($civilization_code)) {
                    if ($this->language == 'en'):
                        setError('enter civilization code correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار شماره ملی را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل كود الحضارة بشكل صحيح');
                    endif;
                }

                if (!empty(getErrors())) {
                    redirect("adminpanel/Auth-adminEdit-" . $user_id . "?error=true");
                }
                if (empty(getErrors())) {
                    $this->updateAdminPersonalInformation($user_id, $name, $mobile, $civilization_code, $iban, $credit_card_number);

                    redirect("adminpanel/Auth-adminList?success=true");
                }

            }
        }

        if ($act == "changeAdminAvatar") {
            if ($_POST) {
                if (!isset($_REQUEST['error'])) {
                    destroyErrors();
                    requestSessionDestroy();
                }

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

                $user_id = sanitizeInput($_POST['user_id']);

                $user_info = $this->user($user_id)[0];

                if (!empty(getErrors())) {
                    redirect("adminpanel/Auth-adminEdit-" . $user_id . "?error=true");
                }

                if (!empty($_FILES['avatar']) and $_FILES['avatar']['name'] != '') {
                    $avatar = $_FILES['avatar'];


                    if (empty(getErrors())) {
                        $image = file_upload($avatar, 'admin', ['png', 'svg', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG']);

                        if ($image == '') {
                            if ($this->language == 'en'):
                                setError('enter image with correct format');
                            elseif ($this->language == 'fa'):
                                setError('تصویر را با فرمت صحیح وارد کنید');
                            elseif ($this->language == 'ar'):
                                setError('أدخل الصورة بالتنسيق الصحيح');
                            endif;
                        } else {
                            destroy_file($user_info['avatar']);
                            $this->updateAdminAvatar($user_id, $image);
                        }
                    }
                }

                redirect("adminpanel/Auth-adminEdit-" . $user_id . "?success=true");
            }
        }

        if ($act == "applyAccessLevel") {
            if ($this->language != "fa") {
                redirect("adminpanel/Setting-changeLanguage-fa");
            }
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            $user_id = $option;
            $user_info = $this->user($user_id)[0];
            $groups = $this->getGroups();

            renderView("admin.$this->language.auth.admin_group_create", ['token' => $token, 'builder' => $this->builder, 'user_name' => $user_info['name'], 'user_id' => $user_id, 'groups' => $groups]);
        }

        if ($act == "applyAccessLevelProcess") {

            if ($_POST) {
                if (!isset($_REQUEST['error'])) {
                    destroyErrors();
                    requestSessionDestroy();
                }

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

                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    if ($this->language == 'en'):
                        setError('enter captcha value correctly');
                    elseif ($this->language == 'fa'):
                        setError('مقدار کپچا را به درستی وارد کنید');
                    elseif ($this->language == 'ar'):
                        setError('أدخل کلمة تحقیق بشكل صحيح');
                    endif;
                }
                $user_id = sanitizeInput($_POST['user_id']);
                $group_id = sanitizeInput($_POST['group']);

                if (empty(getErrors())) {
                    $this->addUserGroup($user_id, $group_id);
                    redirect("adminpanel/Auth-adminList");
                } else {
                    redirect("adminpanel/Auth-applyAccessLevel-" . $user_id."?error=true");
                }

            }
        }

        if ($act == "signout") {
            logout();
            redirect("adminpanel/Auth-signin");
        }
    }

    public function register($email, $password)
    {
        $created_at = date("Y/m/d H:i:s");
        $created_at_jalali = CalendarUtils::strftime("Y/m/d H:i:s");

        $data['email'] = $email;
        $data['password'] = $password;
        $data['created_at'] = $created_at;
        $data['created_at_jalali'] = $created_at_jalali;
        return $this->db->insert("users", $data);
    }

    public function checkIfUserIsSignedup($email)
    {
        return $this->db->rawQuery("select * from `users` where `email`='" . $email . "'");

    }

    public function signin($email, $password)
    {
        $result = $this->db->rawQuery("select * from `users` where `email`='" . $email . "' and `password`='" . $password . "' and `is_admin`=1 and `is_verified`=1 and `is_ban`=0");
        if ($result)
            return true;
        return false;

    }

    public function user($user_id)
    {
        $result = $this->db->rawQuery("select * from `users` where `id`='" . $user_id . "'");
        if ($result)
            return $result;
        return false;
    }

    private function users()
    {
        $query = "select * from `users` order by `id` desc";
        return $this->db->rawQuery($query);
    }

    private function updateUserSituation($user_id, $situation)
    {
        $data = [
            'is_verified' => $situation
        ];
        if ($situation == 1) {
            $data['is_admin'] = 1;
        } else {
            $data['is_admin'] = 0;
        }

        return $this->db->update("users", $data, "id='" . $user_id . "'");
    }

    private function banUser($user_id, $situation)
    {
        $data = [
            'is_ban' => $situation
        ];

        return $this->db->update("users", $data, "id='" . $user_id . "'");
    }

    private function deleteUser($user_id)
    {
        $query = "delete from `users` where `id`='" . $user_id . "'";
        return $this->db->rawQuery($query);
    }

    private function updateAdminPersonalInformation($user_id, $name, $mobile, $civilization_code, $iban, $credit_card_number)
    {
        $data = [
            'name' => $name,
            'mobile' => $mobile,
            'civilization_code' => $civilization_code,
            'iban' => $iban,
            'credit_card_number' => $credit_card_number,
        ];

        return $this->db->update("users", $data, "id='" . $user_id . "'");
    }

    private function updateAdminAvatar($user_id, $avatar)
    {
        $data = [
            'avatar' => $avatar
        ];
        return $this->db->update("users", $data, "id='" . $user_id . "'");
    }

    private function getGroups()
    {
        return $this->db->select_q("groups", [], "order by id desc");
    }

    private function addUserGroup($user_id, $group_id)
    {

        $data = [
            'group_id' => $group_id,
            'user_id' => $user_id
        ];
        return $this->db->insert("group_user", $data);
    }


}