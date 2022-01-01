<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Admin as AdminModel;

class Index extends AdminBaseController
{

    protected $pageCode = 'home';
    public function isAlreadyLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }

    public function __construct(AdminModel $adminModel)
    {
        $this->adminModel = $adminModel;
    }

    public function login($method, $body)
    {
        if ($method == Constants::REQUEST_METHOD_POST) {
            $admin = $this->adminModel->bind();
            $validate = $admin->adminAuth($body['email'], $body['password']);
            if ($validate) {
                $adminUser = $admin->getAdminUser();
                $user = $admin->getUser();
                Session::set(Constants::LOGGED_IN_ADMIN_USER_ID, $user['id']);
                Session::set(Constants::LOGGED_IN_ADMIN_ID, $adminUser['id']);
                Session::set(Constants::LOGGED_IN_ADMIN_NAME, $user['name']);
                Session::set(Constants::LOGGED_IN_ADMIN_EMAIL, $user['email']);
                $this->setSuccessMessage("logined admin in as " . $user['name']);
                $this->setTemplateVars(['islogin' => 1, 'name' => Session::get(Constants::LOGGED_IN_ADMIN_NAME)]);
                $this->redirect("/admin");
                return true;
            } else {
                $this->setErrorMessage("Invalid Credentials!");
                return false;
            }
        }
        return false;
    }

    public function indexAction()
    {
        if ($this->isAlreadyLoggedIn()) {
            $this->setTemplateVars(['name' => Session::get(Constants::LOGGED_IN_ADMIN_NAME), 'islogin' => 1]);
            $this->renderTemplate('Admin/Dashboard/index.html');
        } else {
            if (!$this->login($_SERVER["REQUEST_METHOD"], $_REQUEST)) {
                $this->renderTemplate('Admin/Auth/login.html');
            }
        }
    }

}
