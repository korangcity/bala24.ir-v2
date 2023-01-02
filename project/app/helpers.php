<?php

use App\controller\Database;
use Jenssegers\Blade\Blade;


/**
 * @param $key
 * @param $default
 * @return bool|mixed|string|void
 */
function envv($key, $default = null)
{

    $value = $_ENV[$key];

    if ($value === false) {
        return value($default);
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return;
    }

    return $value;
}

function seprator($st)
{
    $page = explode("/", $st);
    return $page;
}

function httpCheck()
{
    $hostConnection = "http://";
    if (isset($_SERVER['HTTPS'])) {
        if ($_SERVER['HTTPS'] == "on") {
            $hostConnection = "https://";
        }
    }
    return $hostConnection;
}

function baseUrl($hostConnection)
{
    $base_url = $hostConnection . $_SERVER['SERVER_NAME'] . "/";
    return $base_url;
}

function adminPanelUrl($baseUrl)
{
    $adminPanelUrlPrefix = "adminpanel";
    $adminPanelUrl = $baseUrl . $adminPanelUrlPrefix . "/";
    return $adminPanelUrl;
}

function connection($db_host, $db_username, $db_password, $db_database)
{
    $_obj_DataBaseAll = new Database($db_host, $db_username, $db_password, $db_database);
    $_obj_DataBaseAll->connect(true);
    return $_obj_DataBaseAll;
}

function sanitizeInput($data = "")
{
    if (is_array($data)) {
        $data1 = [];
        foreach ($data as $val) {
            $val = preg_replace('/[^a-zA-Z0-9@_\-.+-,:\/\?]/s', ' ', $val);
            $val = trim($data);
            $val = stripslashes($data);
            $data1[] = htmlspecialchars($val);
        }
        $data = $data1;
    } else {
        $data = preg_replace('/[^a-zA-Z0-9@_\-.+-,:\/\?]/s', ' ', $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }

    return $data;
}

function sanitizeInputNonEn($data = "")
{
    if (is_array($data)) {
        $data1 = [];
        foreach ($data as $val) {
            $val = preg_replace('/[^a-zA-Z0-9@_\-.+-,:\/\?]/s', ' ', $val);
            $val = trim($data);
            $val = stripslashes($data);
            $data1[] = htmlspecialchars($val);
        }
        $data = $data1;
    } else {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    return $data;
}

function storageRoot()
{
    return documentRoot() . "storage/";
}

function file_upload($file, $dir, array $extensions)
{
    $dir2 = storageRoot() . $dir . "/";
    $file_name_array = explode('.', $file['name']);
    $extension = end($file_name_array);
    $new_image_name = $file['name'];
    chmod('upload', 0777);
    if (!is_dir($dir2)) {
        mkdir($dir2);
    }
    if (in_array($extension, $extensions)) {
        if (move_uploaded_file($file['tmp_name'], $dir2 . $new_image_name)) {
            return 'storage/' . $dir . '/' . $new_image_name;
        }
    }
}

function file_group_upload(array $files, $dir, array $extensions)
{
    $dir2 = storageRoot() . $dir . "/";
    $imagesLocation = [];
    $error = false;
    foreach ($files['name'] as $key => $fileCheck) {
        $file_name_array = explode('.', $fileCheck);
        $extension = end($file_name_array);
        if (!in_array($extension, $extensions)) {
            $error = true;
        }
    }

    if (!$error) {
        foreach ($files['name'] as $ke => $file) {
            $file_name_array = explode('.', $file);
            $extension = end($file_name_array);
            $new_image_name = $file;
            chmod('upload', 0777);
            if (!is_dir($dir2)) {
                mkdir($dir2);
            }
            if (in_array($extension, $extensions)) {
                if (move_uploaded_file($files['tmp_name'][$ke], $dir2 . $new_image_name)) {
                    $imagesLocation[] = 'storage/' . $dir . '/' . $new_image_name;
                }
            }
        }
    }

    return json_encode($imagesLocation);
}

function destroy_file($file)
{
    if (is_file(documentRoot() . $file)) {
        chmod(documentRoot() . $file, 0777);
        if (unlink(documentRoot() . $file)) {
            return true;
        }
    } else {
        return false;
    }
}

function documentRoot()
{
    return $_SERVER['DOCUMENT_ROOT'] . "/";
}

function generateRandomString($length = 10, $number = 0, $lettercase = 1, $uppercase = 0)
{
    $characters = '';
    if ($number)
        $characters .= '0123456789';
    if ($lettercase)
        $characters .= 'abcdefghijklmnopqrstuvwxyz';
    if ($uppercase)
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function set_cookie($cookie_name, $cookie_value, $time): bool
{
    setcookie($cookie_name, $cookie_value, $time, "/");
    return true;
}

function getCookie($cookie_name)
{
    if (isset($_COOKIE[$cookie_name]))
        return $_COOKIE[$cookie_name];
    return false;

}

function setSession($name, $value)
{
    $_SESSION[$name] = $value;
    return true;
}

function getSession($name)
{
    return $_SESSION[$name];
}

function getUserIpAddress()
{
    return $_SERVER['REMOTE_ADDR'];
}

function getUserAgent()
{
    return $_SERVER["HTTP_USER_AGENT"];
}

function redirect($url)
{
    return header("location:" . httpCheck() . $_SERVER['HTTP_HOST'] . '/' . $url);
}

function errorHandle()
{

    if (envv('SHOW_DEBUG')) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }

    return true;
}

function userTempCode()
{
    return generateRandomString(7, 1, 1, 1);
}

function userCode()
{
    return md5(generateRandomString(7, 1, 1, 1));
}

function marketingLink($userCode)
{
    return httpCheck() . $_SERVER['HTTP_HOST'] . '?user=' . $userCode;
}

function checkIfIbanIsCorrect($iban): bool
{
    $alphabetCodes = [
        'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17,
        'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25,
        'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33,
        'Y' => 34, 'Z' => 35
    ];
    $firstPart = substr(sanitizeInput($iban), 0, 4);
    $secondPart = substr(sanitizeInput($iban), 4);

    $firstAlphbet = strtoupper(substr($firstPart, 0, 1));
    $secondAlphabet = strtoupper(substr($firstPart, 1, 1));
    $firstPart = $firstAlphbet . $secondAlphabet . substr($firstPart, 2);

    if (!in_array($firstAlphbet, array_flip($alphabetCodes)))
        return false;

    if (!in_array($secondAlphabet, array_flip($alphabetCodes)))
        return false;

    $firstAlphbetCode = $alphabetCodes[$firstAlphbet];
    $secondAlphbetCode = $alphabetCodes[$secondAlphabet];
    $firstPartCorrection = str_replace($firstAlphbet, $firstAlphbetCode, $firstPart);
    $firstPartCorrection = str_replace($secondAlphabet, $secondAlphbetCode, $firstPartCorrection);

    $lastVersionIban = $secondPart . $firstPartCorrection;


    if (strlen($lastVersionIban) == 28 and bcmod($lastVersionIban, '97') == 1)
        return true;

    return false;
}

function checkIfBankCardNumberIsCorrect($bank_card_number): bool
{
    $bank_card_number = str_split($bank_card_number);
    $result = [];
    foreach ($bank_card_number as $key => $item) {
        if (($key + 1) % 2 == 0) {
            $result[$key] = $item * 1;
        } else {
            $result[$key] = ($item * 2) > 9 ? ($item * 2) - 9 : $item * 2;
        }
    }
    $sumOfArray = array_sum($result);
    if (count($bank_card_number) == 16 and $sumOfArray % 10 == 0)
        return true;
    return false;
}

function checkIfCivilizationCodeIsCorrect($civilization_code): bool
{
    if ($civilization_code == '0123456789')
        return false;
    $civilization_code = array_reverse(str_split($civilization_code));
    $result = [];
    foreach ($civilization_code as $key => $item) {
        if ($key != 0):
            $result[$key - 1] = $item * ($key + 1);
        endif;
    }
    $resultSum = array_sum($result);
    if ((($resultSum % 11) < 2 and $civilization_code[0] == ($resultSum % 11)) or (($resultSum % 11) >= 2 and $civilization_code[0] == (11 - ($resultSum % 11))))
        return true;
    return false;
}

function checkIfMobileIsCorrect($mobile): bool
{
    if (substr($mobile, 0, 2) == "09" and strlen($mobile) == 11 and ctype_digit($mobile))
        return true;
    return false;
}

function newRequest($name, $input): bool
{
    $_SESSION['REQUEST'][$name] = $input;
    return true;
}

function old($name)
{
    return isset($_SESSION['REQUEST']) ? $_SESSION['REQUEST'][$name] : '';
}

function requestSessionDestroy(): bool
{
    unset($_SESSION['REQUEST']);
    return true;
}

function renderView($template, $args = [])
{
    $views = __DIR__ . '/../view';
    $cache = __DIR__ . '/../storage/views';
    $blade = new Blade($views, $cache);

    return $blade->make($template, $args)->render();
}

function emailVerify($email): bool
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    return false;
}

function urlVerify($url): bool
{
    if (filter_var($url, FILTER_VALIDATE_URL))
        return true;
    return false;
}

function setError($error): bool
{
    $_SESSION['Error'][] = $error;
    return true;
}

function getErrors()
{
    return $_SESSION['Error'] ?? [];
}

function destroyErrors()
{
    unset($_SESSION['Error']);
    return true;
}

function login()
{
    $_SESSION['login'] = true;
    return true;
}

function checkLogin()
{
    if (isset($_SESSION['login']) and $_SESSION['login'])
        return true;
    return false;
}

function logout()
{
    unset($_SESSION['login']);
    unset($_SESSION['USER']);
    set_cookie('login', ' ', time() - envv('ONE_DAY'));
    set_cookie('email', ' ', time() - envv('ONE_DAY'));
    set_cookie('password', ' ', time() - envv('ONE_DAY'));
    return true;
}

function set_user_info($email, $password)
{
    $_SESSION['USER']['email'] = $email;
    $_SESSION['USER']['password'] = $password;
    return true;
}

function get_user_info()
{
    if (isset($_SESSION['USER']))
        return $_SESSION['USER'];
    return false;
}

function setLanguage($lang): bool
{
    $_SESSION['LANG'] = $lang;
    return true;
}

function getLanguage(): string
{
    return isset($_SESSION['LANG']) ? $_SESSION['LANG'] : false;
}

function back()
{
    return header('location:' . $_SERVER['HTTP_REFERER']);
}

function isActive($input)
{
    $currentUrl = substr($_SERVER['REQUEST_URI'], 12);
    return (is_array($input) and in_array($currentUrl, $input)) ? "active" : (($input == $currentUrl) ? "active" : "");

}

