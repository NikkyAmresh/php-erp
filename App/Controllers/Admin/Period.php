<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Period as PeriodHelper;
use App\Models\Admin as AdminModel;

class Period extends AdminController
{
    protected $pageCode = 'period';
    protected $adminModel;
    protected $periodHelper;

    public function __construct(
        AdminModel $adminModel,
        PeriodHelper $periodHelper
    ) {
        $this->periodHelper = $periodHelper;
        parent::__construct($adminModel);
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->periodHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Period created successfully");
            } else {
                $this->setErrorMessage("Unable to create Period");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/period');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->periodHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Period {$_REQUEST['toTime']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Period");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/period');
    }

    public function deleteAction()
    {
        if ($this->periodHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Period delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Period");
        }
        return $this->redirect('/admin/period');
    }

    public function indexAction()
    {
        $data = $this->periodHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Period/index.html');
    }
    public function editAction()
    {
        $data = $this->periodHelper->get($this->route_params['id']);
        if ($data) {
            $this->setTemplateVars($data);
            $this->renderTemplate('Admin/Dashboard/Period/edit.html');
        } else {
            $this->redirect("/admin/period", ["message" => "Invalid TecherID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $this->renderTemplate('Admin/Dashboard/Period/new.html');
    }
}
