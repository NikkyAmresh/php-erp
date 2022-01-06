<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Models\Department as DepartmentHelper;

class Department extends AdminController
{
    protected $pageCode = 'department';
    protected $departmentHelper;
    protected $adminHelper;

    public function __construct(
        DepartmentHelper $departmentHelper,
        AdminHelper $adminHelper
    ) {
        $this->departmentHelper = $departmentHelper;
        parent::__construct($adminHelper);
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
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->departmentHelper->getCollection($page);
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
