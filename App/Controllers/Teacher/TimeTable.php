<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class TimeTable extends TeacherController
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

    public function getAction()
    {
        $st = new TimeTableModel();
        $res = $st->getWithJoin(null, null, ['field' => 'teacherID', 'value' => Session::get(Constants::LOGGED_IN_TEACHER_ID)]);
        //    echo  $teacher->db->getLastQuery();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        View::renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html', array('periods' => $periods, 'days' => $days));
    }
}
