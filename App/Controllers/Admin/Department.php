<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Department as DepartmentModel;

class Department extends AdminController
{
    protected $pageCode = 'department';
    protected $departmentModel;
    protected $adminModel;

    public function __construct(
        DepartmentModel $departmentModel,
        AdminModel $adminModel
    ) {
        $this->departmentModel = $departmentModel;
        parent::__construct($adminModel);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $department = $this->departmentModel->bind();
            $department->setName($_REQUEST['name']);
            if ($department->save()) {
                $this->setSuccessMessage("Department {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Department");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/department');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $department = $this->departmentModel->bind($_REQUEST['id']);
            $department->setName($_REQUEST['name']);
            $department->setHodID($_REQUEST['hod']);
            if ($department->save()) {
                $this->setSuccessMessage("Department {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to create Department");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/department');
    }

    public function deleteAction()
    {
        $department = $this->departmentModel->bind($this->route_params['id']);
        $res = $department->delete();
        if ($res) {
            $this->setSuccessMessage("Department delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Department");
        }
        return $this->redirect('/admin/department');
    }

    public function indexAction()
    {
        $st = $this->departmentModel->bind();
        $res = $st->getWithJoin();
        $columns = array('Serial no', 'Department', 'HOD', 'Edit');
        $this->setTemplateVars(['departments' => $res, 'columns' => $columns, 'result' => $st->result()]);
        $this->renderTemplate('Admin/Dashboard/Department/index.html');

    }
    public function editAction()
    {
        $st = $this->departmentModel->bind($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $hods = $st->getTeachers();
            $this->setTemplateVars(['department' => $res, 'hods' => $hods]);
            $this->renderTemplate('Admin/Dashboard/Department/edit.html');
        } else {
            $this->redirect("/admin/department", ["message" => "Invalid DepartmentID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $this->renderTemplate('Admin/Dashboard/Department/new.html');
    }
}
