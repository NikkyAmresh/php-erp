<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Student;

class StudentController extends StudentBaseController
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_STUDENT_ID);
    }
    public function before()
    {
        parent::before();
        $studentID = $this->isLoggedIn();
        if ($studentID) {
            $this->loggedStudentID = $studentID;
            $this->student = new Student($this->loggedStudentID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->student->getName()]);
            return true;
        }
        $this->setErrorMessage("You must need to login!");
        $this->redirect("/student");
        return false;
    }

}
