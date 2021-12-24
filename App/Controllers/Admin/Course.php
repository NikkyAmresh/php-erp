<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Course as CourseHelper;
use App\Models\Admin as AdminModel;

class Course extends AdminController
{
    protected $pageCode = 'course';
    protected $courseHelper;
    protected $adminModel;
    public function __construct(
        CourseHelper $courseHelper,
        AdminModel $adminModel
    ) {
        $this->courseHelper = $courseHelper;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $data = $this->courseHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Course/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->courseHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Course {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Course");
            }
        } else {
            $this->setErrorMessage("Unable to create Course");
        }
        return $this->redirect('/admin/course');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->courseHelper->update($_REQUEST)) {
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
        if ($this->courseHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("course deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/course');
    }
    public function editAction()
    {
        $res = $this->courseHelper->get($this->route_params['id']);
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
