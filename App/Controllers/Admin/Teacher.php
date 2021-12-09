<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Department;
use App\Models\Teacher as TeacherModel;
use App\Models\User;

class Teacher extends AdminController
{
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $teacher = new User();
            $teacher->setName($_REQUEST['name']);
            $teacher->setMobile($_REQUEST['mobile']);
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
            $teacher = new TeacherModel($_REQUEST['id']);
            $teacher->get();
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
        $teacher = new TeacherModel($this->route_params['id']);
        $res = $teacher->delete();
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
        $columns = array('Serial no', 'Name', 'Department', 'Edit');
        $this->setTemplateVars(['teachers' => $res, 'columns' => $columns]);
        $this->renderTemplate('Admin/Dashboard/Teacher/index.html');
    }
    public function editAction()
    {
        $st = new TeacherModel($this->route_params['id']);
        $res = $st->getOneWithJoin();
        if ($res) {
            $depts = (new Department())->getAll();
            $this->setTemplateVars(['teacher' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Teacher/edit.html');
        } else {
            $this->redirect("/admin/teacher", ["message" => "Invalid TecherID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = (new Department())->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Teacher/new.html');
    }
}