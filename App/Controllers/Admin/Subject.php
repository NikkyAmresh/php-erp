<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Department as DepartmentModel;
use App\Models\Subject as SubjectModel;
use \Core\View;

class Subject extends AdminController
{
    public function indexAction()
    {
        $st = new SubjectModel();
        $dep = new DepartmentModel();
        $deps = $dep->getAll();
        $res = $st->getWithJoin();
        View::renderTemplate('Admin/Dashboard/Subject/index.html', array('subjects' => $res, 'deps' => $deps));
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $subject = new SubjectModel();
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
            $subject = new SubjectModel();
            $subject->get($_REQUEST['id']);
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
        $subject = new SubjectModel();
        $res = $subject->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("subject deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/subject');
    }
    public function editAction()
    {
        $st = new SubjectModel();
        $res = $st->get($this->route_params['id']);
        $dep = new DepartmentModel();
        $deps = $dep->getAll();
        if ($res) {
            View::renderTemplate('Admin/Dashboard/subject/edit.html', ['subject' => $res, 'deps' => $deps]);
        } else {
            $this->redirect("/admin/subject", array("message" => "Invalid subject id!", 'type' => Constants::ERROR));
        }
    }
}
