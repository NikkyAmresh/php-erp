<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Models\Student as StudentHelper;
use App\Helpers\Session;

class StudentController extends StudentBaseController
{
    protected $studentHelper;
    /**
     * Class constructor.
     */
    public function __construct(StudentHelper $studentHelper)
    {
        $this->studentHelper = $studentHelper;
    }
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
            $this->student = $this->studentHelper->getUser($this->loggedStudentID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->student->getName()]);
            return true;
        }
        $this->setErrorMessage("You must need to login!");
        $this->redirect("/student");
        return false;
    }

}
