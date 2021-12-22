<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Semester as SemesterModel;

class Semester extends AdminController
{
    protected $pageCode = 'semester';
    protected $adminModel;
    protected $semesterModel;
    public function __construct(
        SemesterModel $semesterModel,
        AdminModel $adminModel
    ) {
        $this->semesterModel = $semesterModel;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $st = $this->semesterModel->bind();
        $res = $st->getAll();
        $columns = array('Serial no', 'Name', 'Edit');
        $this->setTemplateVars(['semesters' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()]);
        $this->renderTemplate('Admin/Dashboard/Semester/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $semester = $this->semesterModel->bind();
            $semester->setName($_REQUEST['name']);
            $semester->save();
            $this->setSuccessMessage("semester created successfully");
        } else {
            $this->setErrorMessage("Unable to create semester");
        }
        return $this->redirect('/admin/semester');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $semester = $this->semesterModel->bind($_REQUEST['id']);
            $semester->setName($_REQUEST['name']);
            if ($semester->save()) {
                $this->setSuccessMessage("semester updated successfully");
            } else {
                $this->setErrorMessage("Unable to update semester");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/semester');
    }

    public function deleteAction()
    {
        $semester = $this->semesterModel->bind($this->route_params['id']);
        $res = $semester->delete();
        if ($res) {
            $this->setSuccessMessage("semester deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/semester');
    }
    public function editAction()
    {
        $st = $this->semesterModel->bind($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $this->setTemplateVars(['semester' => $res]);
            $this->renderTemplate('Admin/Dashboard/semester/edit.html');
        } else {
            $this->redirect("/admin/semester", ["message" => "Invalid semester id!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $this->renderTemplate('Admin/Dashboard/Semester/new.html');
    }
}
