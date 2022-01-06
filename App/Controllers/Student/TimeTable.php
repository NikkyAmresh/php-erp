<?php

namespace App\Controllers\Student;

use App\Helpers\Models\Student as StudentHelper;
use App\Models\Period as PeriodHelper;

class TimeTable extends StudentController
{
    protected $pageCode = 'timetable';
    protected $periodHelper;
    protected $studentHelper;
    /**
     * Class constructor.
     */
    public function __construct(PeriodHelper $periodHelper, StudentHelper $studentHelper)
    {
        $this->periodHelper = $periodHelper;
        parent::__construct($studentHelper);
    }
    public function getAction()
    {
        $res = $this->student->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = $this->periodHelper->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Student/Dashboard/TimeTable/TimeTable.html');
    }
}
