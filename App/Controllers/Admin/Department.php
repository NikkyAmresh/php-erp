<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Department as DepartmentHelper;
use App\Models\Admin as AdminModel;

class Department extends AdminController
{
    protected $pageCode = 'department';
    protected $departmentHelper;
    protected $adminModel;

    public function __construct(
        DepartmentHelper $departmentHelper,
        AdminModel $adminModel
    ) {
        $this->departmentHelper = $departmentHelper;
        parent::__construct($adminModel);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->departmentHelper->create($_REQUEST)) {
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
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->departmentHelper->update($_REQUEST)) {
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
        if ($this->departmentHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Department delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Department");
        }
        return $this->redirect('/admin/department');
    }

    public function indexAction()
    {
        $data = $this->departmentHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Department/index.html');

    }
    public function editAction()
    {
        $data = $this->departmentHelper->get($this->route_params['id']);
        if ($data) {
            $this->setTemplateVars($data);
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
