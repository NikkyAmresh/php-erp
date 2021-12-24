<?php

namespace App\Controllers\Admin;

use App\Helpers\Classes as ClassModel;
use App\Helpers\Period as PeriodModel;
use App\Helpers\Subject as SubjectModel;
use App\Helpers\Teacher as TeacherModel;
use App\Helpers\TimeTable as TimeTableModel;
use App\Models\Admin as AdminModel;

class TimeTable extends AdminController
{
    protected $pageCode = 'timetable';
    protected $adminModel;
    protected $periodModel;
    protected $classModel;
    protected $subjectModel;
    protected $teacherModel;
    protected $timeTableModel;

    public function __construct(
        AdminModel $adminModel,
        PeriodHelper $periodModel,
        SubjectHelper $subjectModel,
        TeacherHelper $teacherModel,
        ClassHelper $classModel,
        TimeTableHelper $timeTableHelper
    ) {
        $this->periodHelper = $periodHelper;
        $this->classHelper = $classHelper;
        $this->subjectHelper = $subjectHelper;
        $this->teacherHelper = $teacherHelper;
        $this->classHelper = $classHelper;
        $this->timeTableHelper = $timeTableHelper;
        parent::__construct($adminModel);
    }

    public function updateByClassAction()
    {
        $timeTable = $this->timeTableModel->bind();
        $q1 = $timeTable->deleteMany(['classID' => $_REQUEST['classID']]);
        $timeTable = $this->timeTableModel->bind();
        $q2 = $timeTable->insertMulti($_REQUEST['data']);
        echo $q1 . $q2;

    }

    public function getAction()
    {
        $st = $this->classModel->bind($this->route_params['id']);
        $res = $st->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function indexAction()
    {
        $st = $this->timeTableModel->bind();
        $res = $st->getCollection();
        $subjects = $this->subjectModel->bind();
        $subRes = $subjects->getAll();
        $periods = $this->periodModel->bind()->getAll();
        $classes = $this->classModel->bind();
        $classRes = $classes->getCollection();
        $teacher = $this->teacherModel->bind();
        $teacherRes = $teacher->getCollection();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars(['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}
