<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Student;

class StudentController extends \Core\Controller
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_STUDENT_ID);
    }
    public function before()
    {
        $studentID = $this->isLoggedIn();
        if ($studentID) {
            $this->loggedStudentID = $studentID;
            $this->student = new Student($this->loggedStudentID);
            return true;
        }
        $this->redirect("/student", ["message" => "You must need to login!", 'type' => Constants::ERROR]);
        return false;
    }

}
