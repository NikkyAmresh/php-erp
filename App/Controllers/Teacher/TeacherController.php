<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Teacher as TeacherModel;

class TeacherController extends TeacherBaseController
{
    protected $teacherModel;
    public function __construct(TeacherModel $teacherModel)
    {
        $this->teacherModel = $teacherModel;
    }

    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_TEACHER_ID);
    }
    public function before()
    {
        parent::before();
        $teacherID = $this->isLoggedIn();
        if ($this->isLoggedIn()) {
            $this->loggedTeacherID = $teacherID;
            $this->teacher = $this->teacherModel->bind($this->loggedTeacherID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->teacher->getName()]);
            return true;
        }
        $this->redirect("/teacher", ["message" => "You must need to login!", 'type' => Constants::ERROR]);
        return false;
    }

}
