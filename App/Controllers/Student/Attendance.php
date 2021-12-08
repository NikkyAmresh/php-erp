<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;

class Attendance extends StudentController
{
    public function indexAction()
    {
        // $res = $this->student->getAttendanceBySubject('BCST-502');
        // $res = $this->student->getAllAttendance();
        // $res = $this->student->getAttendanceByDay('2021-12-09');
        // $this->setTemplateVars(['data' => json_encode($res)]);
        $data = [
            ['id' => '1', 'name' => 'name1', 'name3' => 'nam34e1', 'code' => 'code1', 'description' => 'lp'],
            ['id' => '2', 'name' => 'name2', 'name3' => 'nam34e1', 'code' => 'code2'],
            ['name' => 'name3', 'name3' => 'nam34e1', 'code' => 'code3', 'id' => '3'],
            ['name' => 'name4', 'id' => '4', 'name3' => 'nam34e1', 'code' => 'code3'],
            ['id' => '5', 'name3' => 'nam34e1', 'code' => 'code3', 'name' => 'name5'],
        ];
        $sqn = ['id', 'name3', 'code', 'name'];
        $this->setTemplateVars(['arrayOfObj' => $data, 'sqn' => $sqn,
            'arrayOfHeadings' => ['serial no', 'Name', 'Extra', 'Code', 'Edit'],
        ]);
        $this->renderTemplate('Student/Dashboard/Attendance/index.html');
    }
}