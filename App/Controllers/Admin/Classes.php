<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Models\Branch as BranchHelper;
use App\Helpers\Models\Classes as ClassHelper;
use App\Helpers\Models\Department as DepartmentHelper;
use App\Helpers\Models\Semester as SemesterHelper;
use App\Helpers\Models\Teacher as TeacherHelper;

class Classes extends AdminController
{

    protected $pageCode = 'classes';
    protected $semesterHelper;
    protected $adminHelper;
    protected $branchHelper;
    protected $classHelper;
    protected $departmentHelper;
    protected $teacherHelper;
    public function __construct(
        SemesterHelper $semesterHelper,
        AdminHelper $adminHelper,
        BranchHelper $branchHelper,
        ClassHelper $classHelper,
        DepartmentHelper $departmentHelper,
        TeacherHelper $teacherHelper
    ) {
        $this->semesterHelper = $semesterHelper;
        $this->branchHelper = $branchHelper;
        $this->departmentHelper = $departmentHelper;
        $this->classHelper = $classHelper;
        $this->teacherHelper = $teacherHelper;
        parent::__construct($adminHelper);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if (
                $this->classHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Class " . $this->classHelper->formatClassName($_REQUEST) . " created successfully");
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
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->classHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Class " . $this->classHelper->formatClassName($_REQUEST) . " updated successfully");
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
        if ($this->classHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Class delete successfully");
        } else {
            $this->setErrorMessage("Unable to delete Class");
        }
        return $this->redirect('/admin/classes');
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->classHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Classes/index.html');
    }
    public function editAction()
    {
        $res = $this->classHelper->get($this->route_params['id']);
        if ($res) {
            $depts = $this->departmentHelper->getAll();
            $branches = $this->branchHelper->getAll();
            $teachers = $this->teacherHelper->getAll();
            $semesters = $this->semesterHelper->getAll();
            $res['name'] = $this->classHelper->formatClassName($res);
            $sections = $this->classHelper->getSections();
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
        $res = $this->classHelper->getAll(null, ['semester', 'asc']);
        $depts = $this->departmentHelper->getAll();
        $branches = $this->branchHelper->getAll();
        $teachers = $this->teacherHelper->getAll();
        $semesters = $this->semesterHelper->getAll();
        $sections = $this->classHelper->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->classHelper->formatClassName($r);
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
