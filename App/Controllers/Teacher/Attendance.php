<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class Attendance extends TeacherController
{

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
        View::renderTemplate('Teacher/Dashboard/TimeTable/index.html', array('timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes));
    }

    public function markAction()
    {
        $st = new TimeTableModel();
        $res = $st->getOneWithJoin($this->route_params['id']);
        $students = new Student();
        $students = $students->getWithJoin(null,null,['field'=>'classID','value'=>$res['classID']]);
        View::renderTemplate('Teacher/Dashboard/Attendance/index.html', array('ets' => json_encode($res),'timeTable'=>$res,'students'=>$students));
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        View::renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html', array('periods' => $periods, 'days' => $days));
    }
}
