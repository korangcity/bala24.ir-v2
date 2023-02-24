<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;


class Redirect
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

    public function act($act, $option = "")
    {
        if ($act == "createRedirect") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.redirect.create", ['token' => $token]);

        }

        if ($act == "createRedirectProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('origin_link', $_POST['origin_link']);
                newRequest('destination_link', $_POST['destination_link']);

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
                    $origin_link = sanitizeInput($_POST['origin_link']);
                    $destination_link = sanitizeInput($_POST['destination_link']);

                else:
                    $origin_link = sanitizeInputNonEn($_POST['origin_link']);
                    $destination_link = sanitizeInputNonEn($_POST['destination_link']);

                endif;

                $origin_link=urldecode($origin_link);
                $destination_link=urldecode($destination_link);

                if (!empty(getErrors())) {
                    redirect('adminpanel/Redirect-createRedirect?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerRedirect($origin_link, $destination_link);
                    redirect('adminpanel/Redirect-redirectList');
                }

            }
        }

        if ($act == "redirectList") {
            $redirects = $this->getRedirects();
            renderView("admin.$this->language.redirect.list", ['redirects' => $redirects]);
        }

        if ($act == "editRedirect") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $redirect_id = $option;
            $redirect = $this->getRedirect($redirect_id)[0];

            renderView("admin.$this->language.redirect.edit", ['token' => $token, 'redirect' => $redirect]);

        }

        if ($act == "editRedirectProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('origin_link', $_POST['origin_link']);
                newRequest('destination_link', $_POST['destination_link']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

                $redirect_id = sanitizeInput($_POST['redirect_id']);
                if ($this->language == 'en'):
                    $origin_link = sanitizeInput($_POST['origin_link']);
                    $destination_link = sanitizeInput($_POST['destination_link']);

                else:
                    $origin_link = sanitizeInputNonEn($_POST['origin_link']);
                    $destination_link = sanitizeInputNonEn($_POST['destination_link']);

                endif;

                $origin_link=urldecode($origin_link);
                $destination_link=urldecode($destination_link);

                if (!empty(getErrors())) {
                    redirect('adminpanel/Redirect-editRedirect' . $redirect_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editRedirect($redirect_id, $origin_link, $destination_link);
                    redirect('adminpanel/Redirect-redirectList');
                }

            }
        }

        if ($act == "redirectDelete") {
            $redirect_id = $option;
            $this->deleteRedirect($redirect_id);
            redirect('adminpanel/Redirect-redirectList');
        }

    }

    private function registerRedirect($origin_link, $destination_link)
    {
        $data = [
            'origin' => $origin_link,
            'destination' => $destination_link
        ];

        return $this->db->insert("redirects", $data);
    }

    private function getRedirects()
    {

        return $this->db->select_q("redirects", [], "order by id desc");
    }

    private function getRedirect($redirect_id)
    {
        $data = [
            'id' => $redirect_id
        ];
        return $this->db->select_q("redirects", $data, "order by id desc");
    }

    private function editRedirect($redirect_id, $origin_link, $destination_link)
    {
        $data = [
            'origin' => $origin_link,
            'destination' => $destination_link
        ];

        return $this->db->update("redirects", $data, "id='" . $redirect_id . "'");
    }

    private function deleteRedirect($redirect_id)
    {
        $query = "delete from `redirects` where `id`='" . $redirect_id . "' limit 1";
        return $this->db->select_old($query);
    }

}