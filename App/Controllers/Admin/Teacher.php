<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Department as DepartmentModel;
use App\Models\Teacher as TeacherModel;
use App\Models\User as UserModel;

class Teacher extends AdminController
{
    protected $pageCode = 'teacher';
    protected $teacherModel;
    protected $departmentModel;
    protected $userModel;
    protected $adminModel;
    public function __construct(
        DepartmentModel $departmentModel,
        TeacherModel $teacherModel,
        UserModel $userModel,
        AdminModel $adminModel
    ) {
        $this->teacherModel = $teacherModel;
        $this->userModel = $userModel;
        $this->departmentModel = $departmentModel;
        parent::__construct($adminModel);
    }

    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            $teacher = $this->userModel->bind();
            $teacher->setName($_REQUEST['name']);
            $teacher->setMobile($_REQUEST['mobile']);
            $teacher->setEmail($_REQUEST['email']);
            $teacher->setPassword(md5($_REQUEST['password']));
            if ($id = $teacher->save()) {
                $teacher = $this->teacherModel->bind();
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
            $teacher = $this->teacherModel->bind($_REQUEST['id']);
            $teacher->get();
            if ($_REQUEST['userID']) {
                $user = $this->userModel->bind();
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
        $teacher = $this->teacherModel->bind($this->route_params['id']);
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
        $st = $this->teacherModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Department', 'Edit');
        $this->setTemplateVars(['teachers' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()]);
        $this->renderTemplate('Admin/Dashboard/Teacher/index.html');
    }
    public function editAction()
    {
        $st = $this->teacherModel->bind($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $depts = ($this->departmentModel->bind())->getAll();
            $this->setTemplateVars(['teacher' => $res, 'deps' => $depts]);
            $this->renderTemplate('Admin/Dashboard/Teacher/edit.html');
        } else {
            $this->redirect("/admin/teacher", ["message" => "Invalid TecherID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $depts = ($this->departmentModel->bind())->getAll();
        $this->setTemplateVars(['deps' => $depts]);
        $this->renderTemplate('Admin/Dashboard/Teacher/new.html');
    }
}
