<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Models\Period as PeriodHelper;

class Period extends AdminController
{
    protected $pageCode = 'period';
    protected $adminHelper;
    protected $periodHelper;

    public function __construct(
        AdminHelper $adminHelper,
        PeriodHelper $periodHelper
    ) {
        $this->periodHelper = $periodHelper;
        parent::__construct($adminHelper);
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
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->periodHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Period/index.html');
    }
    public function editAction()
    {
        $data = $this->periodHelper->get($this->route_params['id']);
        if ($data) {
            $this->setTemplateVars(['period' => $data]);
            $this->renderTemplate('Admin/Dashboard/Period/edit.html');
        } else {
            $this->redirect("/admin/period");
        }
    }
    public function newAction()
    {
        $this->renderTemplate('Admin/Dashboard/Period/new.html');
    }
}
