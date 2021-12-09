<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class Attendance extends TeacherController
{
    protected $pageType = 'attendance';

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
        View::renderTemplate('Teacher/Dashboard/TimeTable/index.html', ['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
    }

    public function markAction()
    {
        $timeTable = new TimeTableModel($this->route_params['id']);
        $res = $timeTable->getOneWithJoin();
        $students = $timeTable->getStudents();
        $this->setTemplateVars(['ets' => json_encode($res), 'timeTable' => $res, 'students' => $students]);
        $this->renderTemplate('Teacher/Dashboard/Attendance/index.html');
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}