<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Department as DepartmentModel;
use App\Models\Teacher;
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
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $department = new DepartmentModel();
            $department->get($_REQUEST['id']);
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
        $res = $st->getWithJoin();
        View::renderTemplate('Admin/Dashboard/Department/index.html', array('department' => $res));
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
            $hods = (new Teacher())->getWithJoin(null, null, array('field' => 'departmentID', 'value' => $res['id']));
            View::renderTemplate('Admin/Dashboard/Department/edit.html', array('department' => $res, 'hods' => $hods));
        } else {
            $this->redirect("/admin/department", array("message" => "Invalid DepartmentID!", 'type' => Constants::ERROR));
        }
    }
}
