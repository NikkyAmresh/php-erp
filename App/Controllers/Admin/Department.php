<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Department as DepartmentModel;

class Department extends AdminController
{
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $department = new DepartmentModel();
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
            $department = new DepartmentModel($_REQUEST['id']);
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
        $department = new DepartmentModel($this->route_params['id']);
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
        $st = new DepartmentModel();
        $res = $st->getWithJoin();
        $this->setTemplateVars(['department' => $res]);
        $this->renderTemplate('Admin/Dashboard/Department/index.html');

    }
    public function editAction()
    {
        $st = new DepartmentModel($this->route_params['id']);
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
