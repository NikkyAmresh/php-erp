<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Semester as SemesterModel;
use \Core\View;

class Semester extends AdminController
{
    public function indexAction()
    {
        $st = new SemesterModel();
        $res = $st->getAll();
        View::renderTemplate('Admin/Dashboard/Semester/index.html', array('semesters' => $res));
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $semester = new SemesterModel();
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
            $semester = new SemesterModel();
            $semester->get($_REQUEST['id']);
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
        $semester = new SemesterModel();
        $res = $semester->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("semester deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/semester');
    }
    public function editAction()
    {
        $st = new SemesterModel();
        $res = $st->get($this->route_params['id']);
        if ($res) {
            View::renderTemplate('Admin/Dashboard/semester/edit.html', ['semester' => $res]);
        } else {
            $this->redirect("/admin/semester", array("message" => "Invalid semester id!", 'type' => Constants::ERROR));
        }
    }
}
