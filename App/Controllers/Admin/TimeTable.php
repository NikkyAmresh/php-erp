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
    protected $period;
    protected $class;
    protected $subject;
    protected $teacher;
    protected $timeTable;

    public function __construct(
        AdminModel $adminModel,
        PeriodModel $period,
        SubjectModel $subject,
        TeacherModel $teacher,
        ClassesModel $class,
        TimeTableModel $timeTable
    ) {
        $this->period = $period;
        $this->class = $class;
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->class = $class;
        $this->timeTable = $timeTable;
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
        $timeTable = $this->timeTable->bind();
        $q1 = $timeTable->deleteMany(['classID' => $_REQUEST['classID']]);
        $timeTable = $this->timeTable->bind();
        $q2 = $timeTable->insertMulti($_REQUEST['data']);
        echo $q1 . $q2;

    }

    public function getAction()
    {
        $st = $this->class->bind($this->route_params['id']);
        $res = $st->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function indexAction()
    {
        $st = $this->timeTable->bind();
        $res = $st->getWithJoin();
        $subjects = $this->subject->bind();
        $subRes = $subjects->getAll();
        $periods = ($this->period->bind())->getAll();
        $classes = $this->class->bind();
        $classRes = $classes->getWithJoin();
        $teacher = $this->teacher->bind();
        $teacherRes = $teacher->getWithJoin();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars(['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}
