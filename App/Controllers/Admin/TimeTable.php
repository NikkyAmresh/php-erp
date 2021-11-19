<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Classes as ClassModel;
use App\Models\Period;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class TimeTable extends AdminController
{
    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $timeTable = new TimeTableModel();
            $timeTable->setPeriodID($_REQUEST['period']);
            $timeTable->setDay($_REQUEST['day']);
            $timeTable->setClassID($_REQUEST['class']);
            $timeTable->setSubjectID($_REQUEST['subject']);
            $timeTable->setTeacherID($_REQUEST['teacher']);

            if ($timeTable->save()) {
                $this->setSuccessMessage("TimeTable created successfully");
            } else {
                $this->setErrorMessage("Unable to create TimeTable");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/timeTable');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['period']))) {
            $timeTable = new TimeTableModel();
            $timeTable->get($_REQUEST['id']);
            $timeTable->setPeriodID($_REQUEST['period']);
            $timeTable->setDay($_REQUEST['day']);
            $timeTable->setClassID($_REQUEST['class']);
            $timeTable->setSubjectID($_REQUEST['subject']);
            $timeTable->setTeacherID($_REQUEST['teacher']);
            if ($timeTable->save()) {
                $this->setSuccessMessage("TimeTable {$_REQUEST['period']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update TimeTable");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/timeTable');
    }

    public function updateByClassAction()
    {
        $timeTable = new TimeTableModel();
        $q1 = $timeTable->deleteMany(['field' => 'classID', 'value' => $_REQUEST['classID']]);
        $timeTable = new TimeTableModel();
        $q2 = $timeTable->insertMulti($_REQUEST['data']);
        echo $q1 . $q2;

    }

    public function deleteAction()
    {
        $timeTable = new TimeTableModel();
        $res = $timeTable->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("TimeTable delete successfully");
        } else {
            $this->setErrorMessage("Unable to create TimeTable");
        }
        return $this->redirect('/admin/timeTable');
    }

    // public function indexAction()
    // {
    //     $st = new TimeTableModel();
    //     $res = $st->getWithJoin();
    //     $subjects = new SubjectModel();
    //     $subRes = $subjects->getAll();
    //     $periods = (new Period())->getAll();
    //     $classes = new ClassModel();
    //     $classRes = $classes->getWithJoin();
    //     $teacher = new TeacherModel();
    //     $teacherRes = $teacher->getWithJoin();
    //     $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    //     foreach ($classRes as $key => $r) {
    //         $classRes[$key]['name'] = $this->className($r);
    //     }
    //     View::renderTemplate('Admin/Dashboard/TimeTable/index.html', array('timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes));
    // }
    public function editAction()
    {
        $st = new TimeTableModel();
        $res = $st->get($this->route_params['id']);
        $subjects = new SubjectModel();
        $periods = (new Period())->getAll();
        $subRes = $subjects->getAll();
        $classes = new ClassModel();
        $classRes = $classes->getWithJoin();
        $teacher = new TeacherModel();
        $teacherRes = $teacher->getWithJoin();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        if ($res) {
            View::renderTemplate('Admin/Dashboard/TimeTable/edit.html', array('timeTable' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes));
        } else {
            $this->redirect("/admin/timeTable", array("message" => "Invalid TecherID!", 'type' => Constants::ERROR));
        }
    }

    public function getAction()
    {
        $st = new TimeTableModel();
        $res = $st->getWithJoin(null, null, ['field' => 'classID', 'value' => $this->route_params['id']], null);
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
        View::renderTemplate('Admin/Dashboard/TimeTable/index.html', array('timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes));
    }
}
