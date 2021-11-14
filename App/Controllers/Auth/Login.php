<?php

namespace App\Controllers\Auth;

use \App\Helpers\Constants;
use \App\Helpers\Session;
use \App\Models\User;
use \Core\View;

class Login extends \Core\Controller
{

    public function isAlreadyLoggedIn()
    {
        return Session::get('LOGGED_IN_USER_ID');
    }

    public function login($method, $body)
    {
        if ($method == Constants::REQUEST_METHOD_POST) {
            $usr = new User();
            $validate = $usr->auth($body['email'], $body['password']);
            if ($validate) {
                $user = $usr->getUser();
                Session::set(Constants::LOGGED_IN_USER_ID, $user['id']);
                Session::set(Constants::LOGGED_IN_USER_NAME, $user['name']);
                Session::set(Constants::LOGGED_IN_USER_EMAIL, $user['email']);
                $this->redirect("/", array('message' => "logined in as " . $user['name'], 'type' => Constants::SUCCESS));
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
            $this->redirect("/");
        }

        if (!$this->login($_SERVER["REQUEST_METHOD"], $_REQUEST)) {
            View::renderTemplate('Auth/login.html');
        }
    }
}
