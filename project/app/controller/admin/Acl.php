<?php

namespace App\controller\admin;

use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class Acl
{

    public function __construct()
    {
        $this->db = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));
        $this->sessionProvider = new NativeSessionProvider();
        $this->easyCSRF = new EasyCSRF($this->sessionProvider);
        $this->phraseBuilder = new PhraseBuilder(5, '0123456789');
        $this->builder = new CaptchaBuilder(null, $this->phraseBuilder);
        $this->language = getLanguage();
        if ($this->language != "fa") {
            setLanguage("fa");
            $this->language = "fa";
        }
    }

    public function act($act, $option = '')
    {

        if ($act == "createPermission") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');


            renderView("admin.$this->language.acl.permission_create", ['token' => $token]);
        }

        if ($act == "createPermissionProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('label', $_POST['label']);

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
                    $label = sanitizeInput($_POST['label']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $label = sanitizeInputNonEn($_POST['label']);
                endif;

                if (!empty(getErrors())) {
                    redirect('adminpanel/Acl-createPermission?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerPermission($title, $label);
                    redirect('adminpanel/Acl-permissionList');
                }

            }

        }

        if ($act == "permissionList") {
            $permissions = $this->getPermissions();
            renderView("admin.$this->language.acl.permission_list", ['permissions' => $permissions]);
        }

        if ($act == "permissionEdit") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }

            $permission_id = $option;
            $permission_info = $this->getPermission($permission_id)[0];

            $token = $this->easyCSRF->generate('my_token');

            renderView("admin.$this->language.acl.permission_edit", ['permission' => $permission_info, 'token' => $token]);
        }

        if ($act == "permissionEditProcess") {
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

                $permission_id = sanitizeInput($_POST['permission_id']);

                if ($this->language == 'en'):
                    $title = sanitizeInput($_POST['title']);
                    $label = sanitizeInput($_POST['label']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $label = sanitizeInputNonEn($_POST['label']);
                endif;

                if (!empty(getErrors())) {
                    redirect('adminpanel/Acl-permissionEdit-' . $permission_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editPermission($permission_id, $title, $label);
                    redirect('adminpanel/Acl-permissionList');
                }

            }
        }

        if ($act == "createRole") {

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $permissions = $this->getPermissions();

            renderView("admin.$this->language.acl.role_create", ['token' => $token, "permissions" => $permissions]);
        }

        if ($act == "createRoleProcess") {
            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);
                newRequest('label', $_POST['label']);
                newRequest('permissions', $_POST['permissions']);


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
                    $label = sanitizeInput($_POST['label']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $label = sanitizeInputNonEn($_POST['label']);
                endif;

                $permissions = $_POST['permissions'];

                if (!empty(getErrors())) {
                    redirect('adminpanel/Acl-createRole?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->registerRole($title, $label, $permissions);
                    redirect('adminpanel/Acl-roleList');
                }

            }

        }

        if ($act == "roleList") {

            $roles = $this->getRoles();
            renderView("admin.$this->language.acl.role_list", ['roles' => $roles]);
        }

        if ($act == "getRolePermissions") {
            $role_id = sanitizeInput($_POST['role_id']);
            $permissions = $this->getRolePermissions($role_id);
            $result = '';
            if ($permissions) {

                $result .= "<tbody>";
                foreach ($permissions as $key => $permission) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">' . ($key + 1) . '</th>';
                    $result .= '<td>' . $permission["permissionTitle"] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;
        }

        if ($act == "roleEdit") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $role_id = $option;
            $role_info = $this->getRolePermissions($role_id);

            $permissions = $this->getPermissions();
            $token = $this->easyCSRF->generate('my_token');
            renderView("admin.$this->language.acl.role_edit", ['permissions' => $permissions, 'roles' => $role_info, 'token' => $token]);
        }

        if ($act == "roleEditProcess") {
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
                    $title = sanitizeInput($_POST['title']);
                    $label = sanitizeInput($_POST['label']);
                else:
                    $title = sanitizeInputNonEn($_POST['title']);
                    $label = sanitizeInputNonEn($_POST['label']);
                endif;

                $role_id = sanitizeInput($_POST['role_id']);
                $role_info = $this->getRolePermissions($role_id);
                $permissions = $_POST['permissions'];

                if (!empty(getErrors())) {
                    redirect('adminpanel/Acl-roleEdit=' . $role_id . '?error=true');
                }

                if (empty(getErrors())) {
                    $res = $this->editRole($role_id, $title, $label, $permissions);
                    redirect('adminpanel/Acl-roleList');
                }
            }
        }

        if ($act == "createGroup") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            $roles = $this->getRoles();
            $permissionRoles = $this->getAllRolePermissions();

            renderView("admin.$this->language.acl.group_create", ['roles' => $roles, "permissions" => $permissionRoles, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "createGroupProcess") {


            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);

                if ($checkCsrf === false) {

                    if ($this->language == 'en'):
                        setError('send information correctly');
                    elseif ($this->language == 'fa'):
                        setError('اطلاعات را به درستی ارسال کنید');
                    elseif ($this->language == 'ar'):
                        setError('إرسال المعلومات بشكل صحيح');
                    endif;
                }

//                if ($_POST['captcha'] != $_SESSION['phrase']) {
//                    if ($this->language == 'en'):
//                        setError('enter captcha value correctly');
//                    elseif ($this->language == 'fa'):
//                        setError('مقدار کپچا را به درستی وارد کنید');
//                    elseif ($this->language == 'ar'):
//                        setError('أدخل کلمة تحقیق بشكل صحيح');
//                    endif;
//
//                }

                $roles = $this->getRoles();
                $permissionRoles = $this->getAllRolePermissions();

                $group_roles = [];
                $group_permissions = [];
                if (empty(getErrors())) {
                    $title = sanitizeInputNonEn($_POST['title']);
                    $language_en = $_POST['english'] == "on" ? 1 : 0;
                    $language_fa = $_POST['farsi'] == "on" ? 1 : 0;
                    $language_ar = $_POST['arabic'] == "on" ? 1 : 0;
                    foreach ($roles as $key => $role) {
                        if ($_POST['role' . ($key + 1)] == "on") {
                            $group_roles[] = $role['id'];
                            foreach ($permissionRoles as $ke => $permissionRole) {
                                if (isset($_POST['permission' . $permissionRole['permissionId']]) and $_POST['permission' . $permissionRole['permissionId']] == "on" and !in_array($permissionRole['permissionId'], $group_permissions)) {
                                    $group_permissions[] = $permissionRole['permissionId'];
                                }
                            }
                        }
                    }

                    $this->registerGroup($title, $language_en, $language_fa, $language_ar, $group_roles, $group_permissions);
                    redirect("adminpanel/Acl-groupList");
                } else {
                    redirect("adminpanel/Acl-createGroup");
                }

            }
        }

        if ($act == "groupList") {
            $groups = $this->getGroups();
            renderView("admin.$this->language.acl.group_list", ['groups' => $groups]);
        }

        if ($act == "getGroupPermissions") {
            $group_id = sanitizeInput($_POST['group_id']);
            $permissions = $this->getGroupPermissions($group_id);
            $result = '';
            if ($permissions) {
                $result .= "<tbody>";
                foreach ($permissions as $key => $permission) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">' . ($key + 1) . '</th>';
                    $result .= '<td>' . $permission["permissionTitle"] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;

        }

        if ($act == "getGroupRoles") {
            $group_id = sanitizeInput($_POST['group_id']);
            $roles = $this->getGroupRoles($group_id);
            $result = '';
            if ($roles) {
                $result .= "<tbody>";
                foreach ($roles as $key => $role) {
                    $result .= "<tr>";
                    $result .= '<th scope="row">' . ($key + 1) . '</th>';
                    $result .= '<td>' . $role["roleTitle"] . '</td>';
                    $result .= "</tr>";
                }

                $result .= "</tbody>";
            }

            echo $result;

        }

        if ($act == "groupEdit") {
            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }
            $token = $this->easyCSRF->generate('my_token');
            $this->builder->build();
            $_SESSION['phrase'] = $this->builder->getPhrase();

            $group_id = $option;
            $group_info = $this->getGroup($group_id)[0];
            $group_roles = $this->getGroupRoles($group_id);
            $group_permissions = $this->getGroupPermissions($group_id);
            $roles = $this->getRoles();
            $permissionRoles = $this->getAllRolePermissions();

            renderView("admin.$this->language.acl.group_edit", ['roles' => $roles, "permissions" => $permissionRoles, 'group_permissions' => $group_permissions, 'group' => $group_info, "group_roles" => $group_roles, 'token' => $token, 'builder' => $this->builder]);

        }

        if ($act == "groupEditProcess") {

            if ($_POST) {
                destroyErrors();
                requestSessionDestroy();

                $checkCsrf = $this->easyCSRF->check('my_token', $_POST['token']);
                newRequest('title', $_POST['title']);

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

                $group_id = sanitizeInput($_POST['group_id']);
                $roles = $this->getRoles();
                $permissionRoles = $this->getAllRolePermissions();

                $group_roles = [];
                $group_permissions = [];
                if (empty(getErrors())) {
                    $title = sanitizeInputNonEn($_POST['title']);
                    $language_en = $_POST['english'] == "on" ? 1 : 0;
                    $language_fa = $_POST['farsi'] == "on" ? 1 : 0;
                    $language_ar = $_POST['arabic'] == "on" ? 1 : 0;
                    foreach ($roles as $key => $role) {
                        if ($_POST['role' . ($key + 1)] == "on") {
                            $group_roles[] = $role['id'];
                            foreach ($permissionRoles as $ke => $permissionRole) {
                                if (isset($_POST['permission' . $permissionRole['permissionId']]) and $_POST['permission' . $permissionRole['permissionId']] == "on" and !in_array($permissionRole['permissionId'], $group_permissions)) {
                                    $group_permissions[] = $permissionRole['permissionId'];
                                }
                            }
                        }
                    }

                    $this->editGroup($group_id, $title, $language_en, $language_fa, $language_ar, $group_roles, $group_permissions);
                    redirect("adminpanel/Acl-groupList");
                } else {
                    redirect("adminpanel/Acl-editGroup-" . $group_id);
                }


            }
        }

    }

    private function registerPermission($title, $label)
    {
        $data = [
            'title' => $title,
            'label' => $label
        ];

        return $this->db->insert("permissions", $data);
    }

    private function getPermissions()
    {
        return $this->db->rawQuery("select * from `permissions` order by `id` desc");
    }

    private function getPermission($permission_id)
    {
        $data = [
            'id' => $permission_id
        ];
        return $this->db->select_q("permissions", $data);
    }

    private function editPermission($permission_id, $title, $label)
    {
        $data = [
            'title' => $title,
            'label' => $label
        ];

        return $this->db->update("permissions", $data, "id='" . $permission_id . "'");
    }

    private function registerRole($title, $label, $permissions)
    {
        $data = [
            'title' => $title,
            'label' => $label
        ];

        $lastInsertedRoleId = $this->db->insert("roles", $data);

        foreach ($permissions as $permission) {
            $data1 = [
                'permission' => $permission,
                'role' => $lastInsertedRoleId
            ];
            $this->db->insert('permission_role', $data1);
        }

        return true;
    }

    private function getRolePermissions($role_id)
    {
        $query = "select roles.id AS roleId,roles.title AS roleTitle,roles.label AS roleLabel
        ,permissions.label AS permissionLabel,permissions.title AS permissionTitle,permissions.id AS permissionId,permission_role.permission AS Permission,
        permission_role.role AS Role from `roles` left join `permission_role` on roles.id=permission_role.role right join `permissions` 
        on permission_role.permission=permissions.id where roles.id='" . $role_id . "' order by permissions.id desc";
        return $this->db->rawQuery($query);
    }

    private function getRoles()
    {
        return $this->db->rawQuery("select * from `roles` order by `id` desc");
    }

    private function editRole($role_id, $title, $label, $permissions)
    {
        $data = [
            'title' => $title,
            'label' => $label
        ];

        $this->db->update("roles", $data, "id='" . $role_id . "'");

        $this->db->rawQuery("delete from permission_role where `role`='" . $role_id . "'");

        foreach ($permissions as $permission) {
            $data1 = [
                'permission' => $permission,
                'role' => $role_id
            ];
            $this->db->insert('permission_role', $data1);
        }

        return true;
    }

    private function getAllRolePermissions()
    {
        $query = "select roles.id AS roleId,roles.title AS roleTitle,roles.label AS roleLabel
        ,permissions.label AS permissionLabel,permissions.title AS permissionTitle,permissions.id AS permissionId,permission_role.permission AS Permission,
        permission_role.role AS Role from `roles` left join `permission_role` on roles.id=permission_role.role right join `permissions` 
        on permission_role.permission=permissions.id order by roles.id desc";
        return $this->db->rawQuery($query);
    }

    private function registerGroup($title, $language_en, $language_fa, $language_ar, $group_roles, $group_permissions)
    {
        $data = [
            'title' => $title,
            'language_en' => $language_en,
            'language_fa' => $language_fa,
            'language_ar' => $language_ar
        ];

        $groupLastInsertedId = $this->db->insert('groups', $data);

        foreach ($group_roles as $group_role) {

            $data1 = [
                'group_id' => $groupLastInsertedId,
                'role_id' => $group_role
            ];

            $this->db->insert('group_role', $data1);
        }

        foreach ($group_permissions as $group_permission) {

            $data2 = [
                'group_id' => $groupLastInsertedId,
                'permission_id' => $group_permission
            ];

            $this->db->insert('group_permission', $data2);
        }

        return true;

    }

    private function getGroups()
    {
        return $this->db->select_q("groups", [], "order by id desc");
    }

    private function getGroupPermissions($group_id)
    {
        $query = "select groups.id AS groupsId,groups.title AS groupsTitle,groups.language_en AS groupsLanguage_en,groups.language_fa AS groupsLanguage_fa
        ,groups.language_ar AS groupsLanguage_ar
        ,permissions.label AS permissionLabel,permissions.title AS permissionTitle,permissions.id AS permissionId,group_permission.permission_id AS Permission,
        group_permission.group_id AS groupId from `groups` left join `group_permission` on groups.id=group_permission.group_id right join `permissions` 
        on group_permission.permission_id=permissions.id where groups.id='" . $group_id . "' order by permissions.id desc";
        return $this->db->rawQuery($query);
    }

    private function getGroupRoles($group_id)
    {
        $query = "select groups.id AS groupsId,groups.title AS groupsTitle,groups.language_en AS groupsLanguage_en,groups.language_fa AS groupsLanguage_fa
        ,groups.language_ar AS groupsLanguage_ar
        ,roles.label AS roleLabel,roles.title AS roleTitle,roles.id AS roleId,group_role.role_id AS Permission,
        group_role.group_id AS groupId from `groups` left join `group_role` on groups.id=group_role.group_id right join `roles` 
        on group_role.role_id=roles.id where groups.id='" . $group_id . "' order by roles.id desc";
        return $this->db->rawQuery($query);
    }

    private function getGroup($group_id)
    {
        $data = [
            'id' => $group_id
        ];
        return $this->db->select_q("groups", $data);
    }

    private function editGroup($group_id, $title, $language_en, $language_fa, $language_ar, $group_roles, $group_permissions)
    {
        $data = [
            'title' => $title,
            'language_en' => $language_en,
            'language_fa' => $language_fa,
            'language_ar' => $language_ar
        ];
        $this->db->update("groups", $data, "id='" . $group_id . "'");

        $this->db->rawQuery("delete from `group_role` where `group_id`='" . $group_id . "'");

        $this->db->rawQuery("delete from `group_permission` where `group_id`='" . $group_id . "'");

        foreach ($group_roles as $group_role) {

            $data1 = [
                'group_id' => $group_id,
                'role_id' => $group_role
            ];

            $this->db->insert('group_role', $data1);
        }

        foreach ($group_permissions as $group_permission) {

            $data2 = [
                'group_id' => $group_id,
                'permission_id' => $group_permission
            ];

            $this->db->insert('group_permission', $data2);
        }

        return true;

    }


}