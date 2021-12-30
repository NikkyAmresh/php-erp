<?php

namespace App\Controllers\Admin;

use App\Helpers\Branch as BranchHelper;
use App\Helpers\Constants;
use App\Helpers\Department as DepartmentHelper;
use App\Models\Admin as AdminModel;

class Branch extends AdminController
{
    protected $pageCode = 'branch';
    protected $departmentHelper;
    protected $adminModel;
    protected $branchHelper;
    public function __construct(
        BranchHelper $branchHelper,
        DepartmentHelper $departmentHelper,
        AdminModel $adminModel
    ) {
        $this->branchHelper = $branchHelper;
        $this->departmentHelper = $departmentHelper;
        parent::__construct($adminModel);
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->branchHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Branch {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Branch");
            }
        } else {
            $this->setErrorMessage("Unable to create Branch");
        }
        return $this->redirect('/admin/branch');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->branchHelper->update($_REQUEST)) {
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
        if ($this->batchHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Branch delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Branch");
        }
        return $this->redirect('/admin/branch');
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->branchHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Branch/index.html');
    }
    public function editAction()
    {
        $res = $this->branchHelper->get($this->route_params['id']);
        $depts = $this->departmentHelper->getAll();
        if ($res) {
            $this->setTemplateVars(['branch' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Branch/edit.html');
        } else {
            $this->redirect("/admin/branch", ["message" => "Invalid BranchID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = $this->departmentHelper->getCollection();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Branch/new.html');
    }
}
