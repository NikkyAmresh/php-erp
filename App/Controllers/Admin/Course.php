<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Course as CourseModel;

class Course extends AdminController
{
    protected $pageCode = 'course';
    protected $course;
    protected $adminModel;
    public function __construct(
        CourseModel $course,
        AdminModel $adminModel
    ) {
        $this->course = $course;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $st = $this->course->bind();
        $res = $st->getAll();
        $columns = array('Serial no', 'Course', 'Duration', 'Edit');
        $this->setTemplateVars(['courses' => $res, 'columns' => $columns, 'result' => $st->result()]);
        $this->renderTemplate('Admin/Dashboard/Course/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $course = $this->course->bind();
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
            $course = $this->course->bind($_REQUEST['id']);
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
        $course = $this->course->bind($this->route_params['id']);
        $res = $course->delete();
        if ($res) {
            $this->setSuccessMessage("course deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/course');
    }
    public function editAction()
    {
        $st = $this->course->bind($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $this->setTemplateVars(['courses' => $res]);
            $this->renderTemplate('Admin/Dashboard/course/edit.html', ['course' => $res]);
        } else {
            $this->redirect("/admin/course", ["message" => "Invalid course id!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $this->renderTemplate('Admin/Dashboard/Course/new.html');
    }
}
