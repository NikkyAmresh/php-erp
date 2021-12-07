<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Branch as BranchModel;
use App\Models\Department;

class Branch extends AdminController
{
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {

            $branch = new BranchModel();
            $branch->setDepartmentID($_REQUEST['department']);
            $branch->setName($_REQUEST['name']);
            $branch->setCode($_REQUEST['code']);
            if (
                $branch->save()) {
                $this->setSuccessMessage("Branch {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Branch");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/branch');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $branch = new BranchModel($_REQUEST['id']);
            $branch->setDepartmentID($_REQUEST['department']);
            $branch->setName($_REQUEST['name']);
            $branch->setCode($_REQUEST['code']);
            if ($branch->save()) {
                $this->setSuccessMessage("Branch {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Branch");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/branch');
    }

    public function deleteAction()
    {
        $branch = new BranchModel($this->route_params['id']);
        $res = $branch->delete();
        if ($res) {
            $this->setSuccessMessage("Branch delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Branch");
        }
        return $this->redirect('/admin/branch');
    }

    public function indexAction()
    {
        $st = new BranchModel();
        $res = $st->getWithJoin();
        $depts = (new Department())->getAll();
        $this->setTemplateVars(['branches' => $res, 'deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Branch/index.html');
    }
    public function editAction()
    {
        $st = new BranchModel($this->route_params['id']);
        $res = $st->getOneWithJoin();
        if ($res) {
            $depts = (new Department())->getAll();
            $this->setTemplateVars(['branch' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Branch/edit.html');
        } else {
            $this->redirect("/admin/branch", ["message" => "Invalid BranchID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = (new Department())->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Branch/new.html');
    }
}
