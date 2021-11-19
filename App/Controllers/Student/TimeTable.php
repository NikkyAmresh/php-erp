<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class TimeTable extends StudentController
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
        View::renderTemplate('Student/Dashboard/TimeTable/index.html', array('timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes));
    }

    public function getAction()
    {
        $st = new TimeTableModel();
        $student = new Student();
        $student->get(Session::get(Constants::LOGGED_IN_STUDENT_ID));
        $res = $st->getWithJoin(null, null, ['field' => 'classID', 'value' => $student->getClassID()]);
    //    echo  $student->db->getLastQuery();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        View::renderTemplate('Student/Dashboard/TimeTable/TimeTable.html', array('periods' => $periods, 'days' => $days));
    }
}
