<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Department as DepartmentHelper;
use App\Helpers\Teacher as TeacherHelper;
use App\Models\Admin as AdminModel;

class Teacher extends AdminController
{
    protected $pageCode = 'teacher';
    protected $teacherHelper;
    protected $departmentHelper;
    protected $adminModel;
    public function __construct(
        DepartmentHelper $departmentHelper,
        TeacherHelper $teacherHelper,
        AdminModel $adminModel
    ) {
        $this->teacherHelper = $teacherHelper;
        $this->departmentHelper = $departmentHelper;
        parent::__construct($adminModel);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->teacherHelper->create($_REQUEST)) {

                $this->setSuccessMessage("Teacher {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Teacher");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/teacher');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->teacherHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Teacher {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Teacher");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/teacher');
    }

    public function deleteAction()
    {
        if ($this->teacherHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Teacher delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Teacher");
        }
        return $this->redirect('/admin/teacher');
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->teacherHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Teacher/index.html');
    }
    public function editAction()
    {
        $res = $this->teacherHelper->getAll($this->route_params['id']);
        if ($res) {
            $depts = $this->departmentHelper->getAll();
            $this->setTemplateVars(['teacher' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Teacher/edit.html');
        } else {
            $this->redirect("/admin/teacher", ["message" => "Invalid TecherID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = $this->departmentHelper->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Teacher/new.html');
    }
}
