<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Models\Period as PeriodModel;
use App\Models\Student as StudentModel;

class TimeTable extends StudentController
{
    protected $pageCode = 'timetable';
    protected $period;
    protected $studentModel;
    /**
     * Class constructor.
     */
    public function __construct(PeriodModel $period, StudentModel $studentModel)
    {
        $this->period = $period;
        parent::__construct($studentModel);
    }
    public function getAction()
    {
        $res = $this->student->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = ($this->period->bind())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Student/Dashboard/TimeTable/TimeTable.html');
    }
}
