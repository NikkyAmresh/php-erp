<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Session;

class StudentController extends \Core\Controller
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_STUDENT_ID);
    }
    public function before()
    {
        if ($this->isLoggedIn()) {
            return true;
        }
        $this->redirect("/student", array("message" => "You must need to login!", 'type' => Constants::ERROR));
        return false;
    }

}
