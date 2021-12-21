<?php

namespace App\Controllers\Teacher;

use App\Models\Period as PeriodModel;
use App\Models\Teacher as TeacherModel;

class TimeTable extends TeacherController
{
    protected $pageCode = 'timetable';
    protected $periodModel;
    protected $teacherModel;
    /**
     * Class constructor.
     */
    public function __construct(PeriodModel $periodModel, TeacherModel $teacherModel)
    {
        $this->periodModel = $periodModel;
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
        $periods = $this->periodModel->bind()->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}
