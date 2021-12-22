<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Branch as BranchModel;
use App\Models\Classes as ClassModel;
use App\Models\Department as DepartmentModel;
use App\Models\Semester as SemesterModel;
use App\Models\Teacher as TeacherModel;

class Classes extends AdminController
{

    protected $pageCode = 'classes';
    protected $semesterModel;
    protected $adminModel;
    protected $branchModel;
    protected $classModel;
    protected $departmentModel;
    protected $teacherModel;
    public function __construct(
        SemesterModel $semesterModel,
        AdminModel $adminModel,
        BranchModel $branchModel,
        ClassModel $classModel,
        DepartmentModel $departmentModel,
        TeacherModel $teacherModel
    ) {
        $this->semesterModel = $semesterModel;
        $this->branchModel = $branchModel;
        $this->departmentModel = $departmentModel;
        $this->classModel = $classModel;
        $this->teacherModel = $teacherModel;
        parent::__construct($adminModel);
    }
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

            $class = $this->classModel->bind();
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
            $class = $this->classModel->bind($_REQUEST['id']);
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
        $class = $this->classModel->bind($this->route_params['id']);
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
        $st = $this->classModel->bind(null, null, ['semester', 'asc']);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Class Teacher', 'Edit');
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars([
            'columns' => $columns,
            'classes' => $res,
            'sections' => $sections,
            'result' => $st->getPaginationSummary(),
        ]);
        $this->renderTemplate('Admin/Dashboard/Classes/index.html');
    }
    public function editAction()
    {
        $st = $this->classModel->bind($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $depts = $this->departmentModel->bind()->getCollection();
            $branches = $this->branchModel->bind()->getCollection();
            $teachers = $this->teacherModel->bind()->getCollection();
            $semesters = $this->semesterModel->bind()->getCollection();
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
        $st = $this->classModel->bind(null, null, ['semester', 'asc']);
        $res = $st->getCollection();
        $depts = $this->departmentModel->bind()->getCollection();
        $branches = $this->branchModel->bind()->getCollection();
        $teachers = $this->teacherModel->bind()->getCollection();
        $semesters = $this->semesterModel->bind()->getCollection();
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
