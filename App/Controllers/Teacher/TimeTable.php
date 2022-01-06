<?php

namespace App\Controllers\Teacher;

use App\Helpers\Models\Teacher as TeacherHelper;
use App\Helpers\Models\Period as PeriodHelper;

class TimeTable extends TeacherController
{
    protected $pageCode = 'timetable';
    protected $periodHelper;
    protected $teacherHelper;
    /**
     * Class constructor.
     */
    public function __construct(PeriodHelper $periodHelper, TeacherHelper $teacherHelper)
    {
        $this->periodHelper = $periodHelper;
        parent::__construct($teacherHelper);
    }
    public function getAction()
    {
        $res = $this->teacher->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = $this->periodHelper->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}
