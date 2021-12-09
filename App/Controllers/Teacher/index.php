<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Teacher;

class Index extends TeacherBaseController
{
    protected $pageType = 'home';
    public function isAlreadyLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_TEACHER_ID);
    }

    public function login($method, $body)
    {
        if ($method == Constants::REQUEST_METHOD_POST) {
            $teacher = new Teacher();
            $validate = $teacher->teacherAuth($body['email'], $body['password']);
            if ($validate) {
                $user = $teacher->getUser();
                $teacherUser = $teacher->getTeacherUser();
                Session::set(Constants::LOGGED_IN_TEACHER_USER_ID, $user['id']);
                Session::set(Constants::LOGGED_IN_TEACHER_ID, $teacherUser['id']);
                Session::set(Constants::LOGGED_IN_TEACHER_NAME, $user['name']);
                Session::set(Constants::LOGGED_IN_TEACHER_EMAIL, $user['email']);
                $this->setSuccessMessage("logined teacher in as " . $user['name']);
                $this->redirect("/teacher");
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
            $this->setTemplateVars(['name' => Session::get(Constants::LOGGED_IN_TEACHER_NAME), 'islogin' => 1]);
            $this->renderTemplate('Teacher/Dashboard/index.html');
        } else {
            if (!$this->login($_SERVER["REQUEST_METHOD"], $_REQUEST)) {
                $this->renderTemplate('Teacher/Auth/login.html');
            }
        }
    }
}