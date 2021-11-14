<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Department as DepartmentModel;
use \Core\View;

class Department extends \Core\Controller
{

    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }

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

    public function deleteAction()
    {
        $department = new DepartmentModel();
        $res = $department->delete($this->route_params['id']);
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
        $res = $st->getAll();
        View::renderTemplate('Admin/Dashboard/department.html', array('department' => $res));
    }

    public function after()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect("/admin", array("message" => "You must need to login!", 'type' => Constants::ERROR));
        }

    }
    public function editAction()
    {
        $st = new DepartmentModel();
        $res = $st->get($this->route_params['id']);
        if ($res) {
            View::renderTemplate('Admin/Dashboard/editDepartment.html', array('department' => $res));
        } else {
            $this->redirect("/admin/department", array("message" => "Invalid DepartmentID!", 'type' => Constants::ERROR));
        }
    }
}
