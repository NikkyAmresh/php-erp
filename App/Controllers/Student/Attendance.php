<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;

class Attendance extends StudentController
{
    protected $pageCode = 'attendance';
    public function indexAction()
    {
        $res = $this->student->getAttendanceBySubject('BCST-502');
        $this->setTemplateVars(['data' => json_encode($res)]);
        $this->renderTemplate('Student/Dashboard/Attendance/index.html');
    }
}
