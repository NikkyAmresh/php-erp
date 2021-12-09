<?php

namespace App\Controllers\Admin;

use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

class TimeTable extends AdminController
{
    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function updateByClassAction()
    {
        $timeTable = new TimeTableModel();
        $q1 = $timeTable->deleteMany(['field' => 'classID', 'value' => $_REQUEST['classID']]);
        $timeTable = new TimeTableModel();
        $q2 = $timeTable->insertMulti($_REQUEST['data']);
        echo $q1 . $q2;

    }

    public function getAction()
    {
        $st = new ClassModel($this->route_params['id']);
        $res = $st->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function indexAction()
    {
        $st = new TimeTableModel();
        $res = $st->getWithJoin();
        $subjects = new SubjectModel();
        $subRes = $subjects->getAll();
        $periods = (new Period())->getAll();
        $classes = new ClassModel();
        $classRes = $classes->getWithJoin();
        $teacher = new TeacherModel();
        $teacherRes = $teacher->getWithJoin();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars(['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}