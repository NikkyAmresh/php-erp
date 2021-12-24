<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Department as DepartmentHelper;
use App\Helpers\Subject as SubjectHelper;
use App\Models\Admin as AdminModel;

class Subject extends AdminController
{
    protected $pageCode = 'subject';
    protected $adminModel;
    protected $departmentHelper;
    protected $subjectHelper;

    public function __construct(
        AdminModel $adminModel,
        DepartmentHelper $departmentHelper,
        SubjectHelper $subjectHelper
    ) {
        $this->departmentHelper = $departmentHelper;
        $this->subjectHelper = $subjectHelper;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $data = $this->subjectHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Subject/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->subjectHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Subject {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Subject");
            }
        } else {
            $this->setErrorMessage("Unable to create Subject");
        }
        return $this->redirect('/admin/subject');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->subjectHelper->update($_REQUEST)) {
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
        if ($this->subjectHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("subject deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/subject');
    }
    public function editAction()
    {
        $res = $this->subjectHelper->get($this->route_params['id']);
        $deps = $this->departmentHelper->getAll();
        if ($res) {
            $this->setTemplateVars(['subject' => $res, 'deps' => $deps]);
            $this->renderTemplate('Admin/Dashboard/subject/edit.html');
        } else {
            $this->redirect("/admin/subject", ["message" => "Invalid subject id!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $deps = $this->departmentHelper->getAll();
        $this->setTemplateVars(['deps' => $deps]);
        $this->renderTemplate('Admin/Dashboard/Subject/new.html');
    }
}
