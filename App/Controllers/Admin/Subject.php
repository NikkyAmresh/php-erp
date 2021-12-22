<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Department as DepartmentModel;
use App\Models\Subject as SubjectModel;

class Subject extends AdminController
{
    protected $pageCode = 'subject';
    protected $adminModel;
    protected $departmentModel;
    protected $subjectModel;

    public function __construct(
        AdminModel $adminModel,
        DepartmentModel $departmentModel,
        SubjectModel $subjectModel
    ) {
        $this->departmentModel = $departmentModel;
        $this->subjectModel = $subjectModel;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $st = $this->subjectModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'edit');
        $this->setTemplateVars(['subjects' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()]);
        $this->renderTemplate('Admin/Dashboard/Subject/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $subject = $this->subjectModel->bind();
            $subject->setName($_REQUEST['name']);
            $subject->setSubjectCode($_REQUEST['subjectCode']);
            $subject->setDepartmentID($_REQUEST['department']);
            $subject->save();
            $this->setSuccessMessage("subject created successfully");
        } else {
            $this->setErrorMessage("Unable to create subject");
        }
        return $this->redirect('/admin/subject');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $subject = $this->subjectModel->bind($_REQUEST['id']);
            $subject->setName($_REQUEST['name']);
            $subject->setSubjectCode($_REQUEST['subjectCode']);
            $subject->setDepartmentID($_REQUEST['department']);
            if ($subject->save()) {
                $this->setSuccessMessage("subject updated successfully");
            } else {
                $this->setErrorMessage("Unable to update subject");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/subject');
    }

    public function deleteAction()
    {
        $subject = $this->subjectModel->bind($this->route_params['id']);
        $res = $subject->delete();
        if ($res) {
            $this->setSuccessMessage("subject deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/subject');
    }
    public function editAction()
    {
        $st = $this->subjectModel->bind($this->route_params['id']);
        $res = $st->get();
        $dep = $this->departmentModel->bind();
        $deps = $dep->getAll();
        if ($res) {
            $this->setTemplateVars(['subject' => $res, 'deps' => $deps]);
            $this->renderTemplate('Admin/Dashboard/subject/edit.html');
        } else {
            $this->redirect("/admin/subject", ["message" => "Invalid subject id!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $dep = $this->departmentModel->bind();
        $deps = $dep->getAll();
        $this->setTemplateVars(['deps' => $deps]);
        $this->renderTemplate('Admin/Dashboard/Subject/new.html');
    }
}
