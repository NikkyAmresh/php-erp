<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;

class Attendance extends StudentController
{
    public function indexAction()
    {
        // $res = $this->student->getAttendanceBySubject('BCST-502');
        $res = $this->student->getAllAttendance();
        // $res = $this->student->getAttendanceByDay('2021-12-09');
        $this->setTemplateVars(['data' => json_encode($res)]);
        $this->renderTemplate('Student/Dashboard/Attendance/index.html');
    }
}