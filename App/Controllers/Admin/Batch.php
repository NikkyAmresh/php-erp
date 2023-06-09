<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Models\Batch as BatchHelper;

class Batch extends AdminController
{
    protected $pageCode = 'batch';
    protected $adminHelper;
    protected $batchModel;
    public function __construct(
        BatchHelper $batchHelper,
        AdminHelper $adminHelper
    ) {
        $this->batchHelper = $batchHelper;
        parent::__construct($adminHelper);
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $data = $this->batchHelper->getCollection($page);
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/Batch/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->batchHelper->create($_REQUEST)) {
                $this->setSuccessMessage("Batch created successfully");
            } else {
                $this->setErrorMessage("Unable to create Batch");
            }
        } else {
            $this->setErrorMessage("Unable to create Batch");
        }
        return $this->redirect('/admin/batch');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if ($this->batchHelper->update($_REQUEST)) {
                $this->setSuccessMessage("Batch updated successfully");
            } else {
                $this->setErrorMessage("Unable to create batch");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/batch');
    }

    public function deleteAction()
    {
        if ($this->batchHelper->delete($this->route_params['id'])) {
            $this->setSuccessMessage("Batch deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/batch');
    }
    public function editAction()
    {
        $res = $this->batchHelper->get($this->route_params['id']);
        $years = $this->batchHelper->get10Years();
        if ($res) {
            $this->setTemplateVars(['batch' => $res, 'years' => $years]);
            $this->renderTemplate('Admin/Dashboard/Batch/edit.html');
        } else {
            $this->redirect("/admin/batch");
        }
    }
    public function newAction()
    {
        $years = $this->batchHelper->get10Years();
        $this->setTemplateVars(['years' => $years]);
        $this->renderTemplate('Admin/Dashboard/Batch/new.html');

    }
}
