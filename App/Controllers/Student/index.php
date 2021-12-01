<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Student;

class Index extends StudentBaseController
{

    public function isAlreadyLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_STUDENT_ID);
    }

    public function login($method, $body)
    {
        if ($method == Constants::REQUEST_METHOD_POST) {
            $student = new Student();
            $validate = $student->studentAuth($body['email'], $body['password']);
            if ($validate) {
                $user = $student->getUser();
                $studentUser = $student->getStudentUser();
                Session::set(Constants::LOGGED_IN_STUDENT_USER_ID, $user['id']);
                Session::set(Constants::LOGGED_IN_STUDENT_ID, $studentUser['id']);
                Session::set(Constants::LOGGED_IN_STUDENT_NAME, $user['name']);
                Session::set(Constants::LOGGED_IN_STUDENT_EMAIL, $user['email']);
                $this->setSuccessMessage("logined student in as " . $user['name']);
                $this->redirect("/student");
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
            $this->setTemplateVars(['name' => Session::get(Constants::LOGGED_IN_STUDENT_NAME), 'islogin' => 1]);
            $this->renderTemplate('Student/Dashboard/Homepage/index.html');
        } else {
            if (!$this->login($_SERVER["REQUEST_METHOD"], $_REQUEST)) {
                $this->renderTemplate('Student/Auth/login.html');
            }
        }
    }
}
