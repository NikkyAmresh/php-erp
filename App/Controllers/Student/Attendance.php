<?php

namespace App\Controllers\Student;

use App\Models\Student as StudentModel;
class Attendance extends StudentController
{

    /**
     * Class constructor.
     */
    public function __construct(StudentModel $studentModel)
    {
        parent::__construct($studentModel);
    }

    protected $pageCode = 'attendance';
    public function indexAction()
    {
        $res = $this->student->getAttendanceBySubject('BCST-502');
        $this->setTemplateVars(['data' => json_encode($res)]);
        $this->renderTemplate('Student/Dashboard/Attendance/index.html');
    }
}
