<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Branch;
use App\Models\Classes as ClassModel;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Teacher;

class Classes extends AdminController
{

    protected $pageType = 'classes';

    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function getSections()
    {
        return [
            ['id' => 'a', 'code' => 'A'],
            ['id' => 'b', 'code' => 'B'],
            ['id' => 'c', 'code' => 'C'],
            ['id' => 'd', 'code' => 'D'],
        ];
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
            $class = new ClassModel($_REQUEST['id']);
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
        $class = new ClassModel($this->route_params['id']);
        $res = $class->delete();
        if ($res) {
            $this->setSuccessMessage("Class delete successfully");
        } else {
            $this->setErrorMessage("Unable to delete Class");
        }
        return $this->redirect('/admin/classes');
    }

    public function indexAction()
    {
        $st = new ClassModel(null, null, ['semester', 'asc']);
        $res = $st->getWithJoin();
        $columns = array('Serial no', 'Name', 'Class Teacher', 'Edit');
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars([
            'columns' => $columns,
            'classes' => $res,
            'sections' => $sections,
        ]);
        $this->renderTemplate('Admin/Dashboard/Classes/index.html');
    }
    public function editAction()
    {
        $st = new ClassModel($this->route_params['id']);
        $res = $st->getOneWithJoin();
        if ($res) {
            $depts = (new Department())->getWithJoin();
            $branches = (new Branch())->getWithJoin();
            $teachers = (new Teacher())->getWithJoin();
            $semesters = (new Semester)->getWithJoin();
            $res['name'] = $this->className($res);
            $sections = $this->getSections();
            $this->setTemplateVars([
                'class' => $res,
                'deps' => $depts,
                'branches' => $branches,
                'teachers' => $teachers,
                'semesters' => $semesters,
                'sections' => $sections,
            ]);
            $this->renderTemplate('Admin/Dashboard/Classes/edit.html');
        } else {
            $this->redirect("/admin/classes", ["message" => "Invalid ClassID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $st = new ClassModel(null, null, ['semester', 'asc']);
        $res = $st->getWithJoin();
        $depts = (new Department())->getWithJoin();
        $branches = (new Branch())->getWithJoin();
        $teachers = (new Teacher())->getWithJoin();
        $semesters = (new Semester)->getWithJoin();
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars([
            'classes' => $res,
            'deps' => $depts,
            'branches' => $branches,
            'teachers' => $teachers,
            'semesters' => $semesters,
            'sections' => $sections,
        ]);
        $this->renderTemplate('Admin/Dashboard/Classes/new.html');
    }
}