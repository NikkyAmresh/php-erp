<?php

namespace App\Controllers\Student;

use App\Helpers\Models\Student as StudentHelper;

class Attendance extends StudentController
{

    /**
     * Class constructor.
     */
    public function __construct(StudentHelper $studentHelper)
    {
        parent::__construct($studentHelper);
    }

    protected $pageCode = 'attendance';
    public function indexAction()
    {
        $res = $this->student->getAttendanceBySubject('BCST-502');
        $this->setTemplateVars(['data' => json_encode($res)]);
        $this->renderTemplate('Student/Dashboard/Attendance/index.html');
    }
}
