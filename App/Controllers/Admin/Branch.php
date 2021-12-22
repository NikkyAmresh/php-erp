<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Branch as BranchModel;
use App\Models\Department as DepartmentModel;

class Branch extends AdminController
{
    protected $pageCode = 'branch';
    protected $branchModel;
    protected $departmentModel;
    protected $adminModel;
    public function __construct(
        BranchModel $branchModel,
        DepartmentModel $departmentModel,
        AdminModel $adminModel
    ) {
        $this->branchModel = $branchModel;
        $this->departmentModel = $departmentModel;
        parent::__construct($adminModel);
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {

            $branch = $this->branchModel->bind();
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
            $branch = $this->branchModel->bind($_REQUEST['id']);
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
        $branch = $this->branchModel->bind($this->route_params['id']);
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
        $st = $this->branchModel->bind();
        $res = $st->get();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'Edit');
        $this->setTemplateVars(['branches' => $res, 'columns' => $columns, 'result' => $st->result()]);
        $this->renderTemplate('Admin/Dashboard/Branch/index.html');
    }
    public function editAction()
    {
        $st = $this->branchModel->bind($this->route_params['id']);
        $res = $st->getOne();
        if ($res) {
            $depts = $this->departmentModel->bind()->getAll();
            $this->setTemplateVars(['branch' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Branch/edit.html');
        } else {
            $this->redirect("/admin/branch", ["message" => "Invalid BranchID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = $this->departmentModel->bind()->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Branch/new.html');
    }
}
