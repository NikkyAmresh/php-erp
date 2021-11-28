<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Admin;

class Index extends AdminBaseController
{

    public function isAlreadyLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }

    public function login($method, $body)
    {
        if ($method == Constants::REQUEST_METHOD_POST) {
            $admin = new Admin();
            $validate = $admin->adminAuth($body['email'], $body['password']);
            if ($validate) {
                $adminUser = $admin->getAdminUser();
                Session::set(Constants::LOGGED_IN_ADMIN_ID, $adminUser['id']);
                Session::set(Constants::LOGGED_IN_ADMIN_NAME, $adminUser['name']);
                Session::set(Constants::LOGGED_IN_ADMIN_EMAIL, $adminUser['email']);
                $this->setSuccessMessage("logined admin in as " . $adminUser['name']);
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
