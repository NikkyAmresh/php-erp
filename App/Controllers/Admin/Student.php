<?php

namespace App\Controllers\Admin;

use App\Helpers\Batch as BatchHelper;
use App\Helpers\Classes as ClassHelper;
use App\Helpers\Constants;
use App\Helpers\Course as CourseHelper;
use App\Helpers\Student as StudentHelper;
use App\Helpers\User as UserHelper;
use App\Models\Admin as AdminModel;

class Student extends AdminController
{
    protected $pageCode = 'student';
    protected $adminModel;
    protected $classHelper;
    protected $courseHelper;
    protected $studentHelper;
    protected $userHelper;
    protected $batchHelper;
    public function __construct(
        AdminModel $adminModel,
        ClassHelper $classHelper,
        BatchHelper $batchHelper,
        StudentHelper $studentHelper,
        UserHelper $userHelper,
        CourseHelper $courseHelper
    ) {
        $this->batchHelper = $batchHelper;
        $this->studentHelper = $studentHelper;
        $this->userHelper = $userHelper;
        $this->classHelper = $classHelper;
        $this->courseHelper = $courseHelper;
        parent::__construct($adminModel);
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {

            if ($this->studentHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Student {$_REQUEST['name']} created successfully");
            } else {
                $user = $this->userModel->bind();
                $this->setErrorMessage($studentHelper->getError());
                $user->delete($id);
            }

        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/student');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            if ($this->studentHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Student {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Student");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/student');
    }

    public function deleteAction()
    {
        if ($this->studentHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Student delete successfully");
        } else {
            $this->setErrorMessage("Unable to delete Student");
        }
        return $this->redirect('/admin/student');
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->studentHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Student/index.html');
    }
    public function editAction()
    {
        $data = $this->studentHelper->get($this->route_params['id']);
        if ($data) {
            $this->setTemplateVars($data);
            $this->renderTemplate('Admin/Dashboard/Student/edit.html');
        } else {
            $this->redirect("/admin/student", ["message" => "Invalid StudentID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $data = $this->studentHelper->getCollectionForNew();
        if ($data) {
            $this->setTemplateVars(
                $data
            );
        }
        $this->renderTemplate('Admin/Dashboard/Student/new.html');
    }
}
