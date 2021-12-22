<?php

namespace App\Controllers\Admin;

use App\Models\Admin as AdminModel;
use App\Models\Classes as ClassesModel;
use App\Models\Period as PeriodModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

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
        PeriodModel $periodModel,
        SubjectModel $subjectModel,
        TeacherModel $teacherModel,
        ClassesModel $classModel,
        TimeTableModel $timeTableModel
    ) {
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
        $this->teacherModel = $teacherModel;
        $this->classModel = $classModel;
        $this->timeTableModel = $timeTableModel;
        parent::__construct($adminModel);
    }
    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
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
        $res = $st->get();
        $subjects = $this->subjectModel->bind();
        $subRes = $subjects->getAll();
        $periods = $this->periodModel->bind()->getAll();
        $classes = $this->classModel->bind();
        $classRes = $classes->get();
        $teacher = $this->teacherModel->bind();
        $teacherRes = $teacher->get();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars(['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}
