<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Admin;
use \Core\View;

class Index extends \Core\Controller

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
            View::renderTemplate('Admin/Dashboard/index.html', ['name' => Session::get(Constants::LOGGED_IN_ADMIN_NAME)]);
        } else {
            if (!$this->login($_SERVER["REQUEST_METHOD"], $_REQUEST)) {
                View::renderTemplate('Admin/Auth/login.html');
            }
        }
    }
}
