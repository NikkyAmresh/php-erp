<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Teacher;

class TeacherController extends \Core\Controller
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_TEACHER_ID);
    }
    public function before()
    {
     
        $teacherID = $this->isLoggedIn();
        if ($this->isLoggedIn()) {
            $this->loggedTeacherID = $teacherID;
            $this->teacher = new Teacher($this->loggedTeacherID);
            return true;
        }
        $this->redirect("/student", ["message" => "You must need to login!", 'type' => Constants::ERROR]);
        return false;
    }

}
