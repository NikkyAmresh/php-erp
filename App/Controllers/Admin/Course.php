<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Course as CourseModel;
use \Core\View;

class Course extends AdminController
{
    public function indexAction()
    {
        $st = new CourseModel();
        $res = $st->getAll();
        View::renderTemplate('Admin/Dashboard/Course/index.html', array('courses' => $res));
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $course = new CourseModel();
            $course->setName($_REQUEST['name']);
            $course->setDuration($_REQUEST['duration']);
            $course->save();
            $this->setSuccessMessage("course created successfully");
        } else {
            $this->setErrorMessage("Unable to create course");
        }
        return $this->redirect('/admin/course');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $course = new CourseModel();
            $course->get($_REQUEST['id']);
            $course->setName($_REQUEST['name']);
            $course->setDuration($_REQUEST['duration']);
            if ($course->save()) {
                $this->setSuccessMessage("course updated successfully");
            } else {
                $this->setErrorMessage("Unable to update course");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/course');
    }

    public function deleteAction()
    {
        $course = new CourseModel();
        $res = $course->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("course deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/course');
    }
    public function editAction()
    {
        $st = new CourseModel();
        $res = $st->get($this->route_params['id']);
        if ($res) {
            View::renderTemplate('Admin/Dashboard/course/edit.html', ['course' => $res]);
        } else {
            $this->redirect("/admin/course", array("message" => "Invalid course id!", 'type' => Constants::ERROR));
        }
    }
}
