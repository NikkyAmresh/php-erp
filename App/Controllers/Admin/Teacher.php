<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Department;
use App\Models\Teacher as TeacherModel;
use App\Models\User;
use \Core\View;

class Teacher extends \Core\Controller
{

    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $teacher = new User();
            $teacher->setName($_REQUEST['name']);
            $teacher->setPhone($_REQUEST['mobile']);
            $teacher->setEmail($_REQUEST['email']);
            $teacher->setPassword(md5($_REQUEST['password']));
            if ($id = $teacher->save()) {
                $teacher = new TeacherModel();
                $teacher->setUserID($id);
                $teacher->setDepartmentID($_REQUEST['department']);
                $teacher->save();
                $this->setSuccessMessage("Teacher {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Teacher");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/teacher');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $teacher = new TeacherModel();
            $teacher->get($_REQUEST['id']);
            if ($_REQUEST['userID']) {
                $user = new User();
                $user->get($_REQUEST['userID']);
                $user->setName($_REQUEST['name'])->save();
            }
            $teacher->setDepartmentID($_REQUEST['department']);
            if ($teacher->save()) {
                $this->setSuccessMessage("Teacher {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Teacher");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/teacher');
    }

    public function deleteAction()
    {
        $teacher = new TeacherModel();
        $res = $teacher->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("Teacher delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Teacher");
        }
        return $this->redirect('/admin/teacher');
    }

    public function indexAction()
    {
        $st = new TeacherModel();
        $res = $st->getWithJoin();
        $depts = (new Department())->getAll();
        View::renderTemplate('Admin/Dashboard/Teacher/index.html', array('teacher' => $res, 'deps' => $depts));
    }

    public function before()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect("/admin", array("message" => "You must need to login!", 'type' => Constants::ERROR));
        }

    }
    public function editAction()
    {
        $st = new TeacherModel();
        $res = $st->getOneWithJoin($this->route_params['id']);
        if ($res) {
            $depts = (new Department())->getAll();
            View::renderTemplate('Admin/Dashboard/Teacher/edit.html', array('teacher' => $res, 'deps' => $depts));
        } else {
            $this->redirect("/admin/teacher", array("message" => "Invalid TecherID!", 'type' => Constants::ERROR));
        }
    }
}
