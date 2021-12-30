<?php
namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Semester as SemesterHelper;
use App\Models\Admin as AdminModel;

class Semester extends AdminController
{
    protected $pageCode = 'semester';
    protected $adminModel;
    protected $semesterHelper;
    public function __construct(
        SemesterHelper $semesterHelper,
        AdminModel $adminModel
    ) {
        $this->semesterHelper = $semesterHelper;
        parent::__construct($adminModel);
    }
    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->semesterHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Semester/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->semesterHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Semester {$_REQUEST['name']} created successfully");
            } else {
                $this->setErrorMessage("Unable to create Semester");
            }
        } else {
            $this->setErrorMessage("Unable to create Semester");
        }
        return $this->redirect('/admin/semester');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->semesterHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Semester {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Semester");
            }
        } else {
            $this->setErrorMessage("Unable to update Semester");
        }
        return $this->redirect('/admin/semester');
    }

    public function deleteAction()
    {
        if ($this->semesterHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("semester deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/semester');
    }
    public function editAction()
    {

        $data = $this->semesterHelper->get($this->route_params['id']);
        if ($data) {
            $this->setTemplateVars($data);
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
