<?php

namespace App\Controllers\Teacher;

use App\Models\Period as PeriodModel;
use App\Models\Teacher as TeacherModel;

class TimeTable extends TeacherController
{
    protected $pageCode = 'timetable';
    protected $period;
    protected $teacherModel;
    /**
     * Class constructor.
     */
    public function __construct(PeriodModel $period, TeacherModel $teacherModel)
    {
        $this->period = $period;
        parent::__construct($teacherModel);
    }
    public function getAction()
    {
        $res = $this->teacher->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = ($this->period->bind())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}
