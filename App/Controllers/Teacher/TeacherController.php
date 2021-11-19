<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Session;

class TeacherController extends \Core\Controller
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_TEACHER_ID);
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
