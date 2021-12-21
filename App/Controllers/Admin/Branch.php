<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Branch as BranchModel;
use App\Models\Department as DepartmentModel;

class Branch extends AdminController
{
    protected $pageCode = 'branch';
    protected $branch;
    protected $department;
    protected $adminModel;
    public function __construct(
        BranchModel $branch,
        DepartmentModel $department,
        AdminModel $adminModel
    ) {
        $this->branch = $branch;
        $this->department = $department;
        parent::__construct($adminModel);
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {

            $branch = $this->branch->bind();
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
            $branch = $this->branch->bind($_REQUEST['id']);
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
        $branch = $this->branch->bind($this->route_params['id']);
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
        $st = $this->branch->bind();
        $res = $st->getWithJoin();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'Edit');
        $this->setTemplateVars(['branches' => $res, 'columns' => $columns, 'result' => $st->result()]);
        $this->renderTemplate('Admin/Dashboard/Branch/index.html');
    }
    public function editAction()
    {
        $st = $this->branch->bind($this->route_params['id']);
        $res = $st->getOneWithJoin();
        if ($res) {
            $depts = ($this->department->bind())->getAll();
            $this->setTemplateVars(['branch' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Branch/edit.html');
        } else {
            $this->redirect("/admin/branch", ["message" => "Invalid BranchID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = ($this->department->bind())->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Branch/new.html');
    }
}
