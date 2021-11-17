<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Branch as BranchModel;
use App\Models\Department;
use App\Models\Periods as PeriodModel;
use App\Models\Semester as SemesterModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use \Core\View;

class Periods extends AdminController
{
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $period = new PeriodModel();
            if (($period->get(null, ['field' => 'teacherID', 'value' => $_REQUEST['teacher']])) && ($period->get(['field' => 'fromTo', 'value' => $_REQUEST['fromTime']]))) {
                $this->setInfoMessage("This Teacher already exists at this time period");

            } else {
                $period->setFromTime($_REQUEST['fromTime']);
                $period->setToTime($_REQUEST['toTime']);
                $period->setDay($_REQUEST['day']);
                $period->setClassID($_REQUEST['class']);
                $period->setSubjectID($_REQUEST['subject']);
                $period->setTeacherID($_REQUEST['teacher']);
            }

            if ($period->save()) {
                $this->setSuccessMessage("Period created successfully");
            } else {
                $this->setErrorMessage("Unable to create Period");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/periods');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $period = new PeriodModel();
            $period->get($_REQUEST['id']);
            if ($period->save()) {
                $this->setSuccessMessage("Period {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Period");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/period');
    }

    public function deleteAction()
    {
        $period = new PeriodModel();
        $res = $period->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("Period delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Period");
        }
        return $this->redirect('/admin/period');
    }

    public function indexAction()
    {
        $st = new PeriodModel();
        $res = $st->getWithJoin();
        $subjects = new SubjectModel();
        $subRes = $subjects->getAll();
        $branches = new BranchModel();
        $branchRes = $branches->getAll();
        $semesters = new SemesterModel();
        $semesterRes = $semesters->getAll();
        $teachers = new TeacherModel();
        $teacherRes = $teachers->getWithJoin();
        print_r($res);
        View::renderTemplate('Admin/Dashboard/Periods/index.html', array('periods' => $res, 'subjects' => $subRes, 'branches' => $branchRes, 'semesters' => $semesterRes, 'teachers' => $teacherRes));
    }
    public function editAction()
    {
        $st = new PeriodModel();
        $res = $st->getOneWithJoin($this->route_params['id']);
        $subjects = new SubjectModel();
        $subRes = $subjects->getAll();
        $branches = new BranchModel();
        $branchRes = $branches->getAll();
        $semesters = new SemesterModel();
        $semesterRes = $semesters->getAll();
        $teachers = new TeacherModel();
        $teacherRes = $teachers->getWithJoin();
        if ($res) {
            $depts = (new Department())->getAll();
            View::renderTemplate('Admin/Dashboard/Periods/edit.html', array('periods' => $res, 'subjects' => $subRes, 'branches' => $branchRes, 'semesters' => $semesterRes, 'teachers' => $teacherRes));
        } else {
            $this->redirect("/admin/period", array("message" => "Invalid TecherID!", 'type' => Constants::ERROR));
        }
    }
}
