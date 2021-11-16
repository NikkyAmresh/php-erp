<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Branch;
use App\Models\Classes as ClassModel;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Teacher;
use \Core\View;

class Classes extends AdminController
{

    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function getSections()
    {
        return array(
            array('id' => 'a', 'code' => 'A'),
            array('id' => 'b', 'code' => 'B'),
            array('id' => 'c', 'code' => 'C'),
            array('id' => 'd', 'code' => 'D'),
        );
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['semester']))) {

            $class = new ClassModel();
            $class->setDepartmentID($_REQUEST['department']);
            $class->setBranchID($_REQUEST['branch']);
            $class->setSemesterID($_REQUEST['semester']);
            $class->setSection($_REQUEST['section']);
            $class->setTeacherID($_REQUEST['teacher']);
            if (
                $class->save()) {
                $this->setSuccessMessage("Class " . $this->className($_REQUEST) . " created successfully");
            } else {
                $this->setErrorMessage("Unable to create Class");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/classes');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['semester']))) {
            $class = new ClassModel();
            $class->get($_REQUEST['id']);
            $class->setDepartmentID($_REQUEST['department']);
            $class->setBranchID($_REQUEST['branch']);
            $class->setSemesterID($_REQUEST['semester']);
            $class->setSection($_REQUEST['section']);
            $class->setTeacherID($_REQUEST['teacher']);
            if ($class->save()) {
                $this->setSuccessMessage("Class " . $this->className($_REQUEST) . " updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Class");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/classes');
    }

    public function deleteAction()
    {
        $class = new ClassModel();
        $res = $class->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("Class delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Class");
        }
        return $this->redirect('/admin/classes');
    }

    public function indexAction()
    {
        $st = new ClassModel();
        $res = $st->getWithJoin(null, null, null, array('semester', 'asc'));
        $depts = (new Department())->getWithJoin();
        $branches = (new Branch())->getWithJoin();
        $teachers = (new Teacher())->getWithJoin();
        $semesters = (new Semester)->getWithJoin();
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->className($r);
        }
        View::renderTemplate('Admin/Dashboard/Classes/index.html', array(
            'classes' => $res,
            'deps' => $depts,
            'branches' => $branches,
            'teachers' => $teachers,
            'semesters' => $semesters,
            'sections' => $sections,
        ));
    }
    public function editAction()
    {
        $st = new ClassModel();
        $res = $st->getOneWithJoin($this->route_params['id']);
        if ($res) {
            $depts = (new Department())->getWithJoin();
            $branches = (new Branch())->getWithJoin();
            $teachers = (new Teacher())->getWithJoin();
            $semesters = (new Semester)->getWithJoin();
            $res['name'] = $this->className($res);
            $sections = $this->getSections();
            View::renderTemplate('Admin/Dashboard/Classes/edit.html', array(
                'class' => $res,
                'deps' => $depts,
                'branches' => $branches,
                'teachers' => $teachers,
                'semesters' => $semesters,
                'sections' => $sections,
            ));
        } else {
            $this->redirect("/admin/classes", array("message" => "Invalid ClassID!", 'type' => Constants::ERROR));
        }
    }
}
