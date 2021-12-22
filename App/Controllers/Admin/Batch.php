<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Batch as BatchModel;

class Batch extends AdminController
{
    protected $pageCode = 'batch';
    protected $adminModel;
    protected $batchModel;
    public function __construct(
        BatchModel $batchModel,
        AdminModel $adminModel
    ) {
        $this->batchModel = $batchModel;
        parent::__construct($adminModel);
    }
    public function get10Years()
    {
        $currentYear = date("Y");
        $fromYears = [];
        $toYears = [];
        for ($i = 0; $i < 11; $i++) {
            array_push($fromYears, $currentYear - $i);
            array_push($toYears, $currentYear + $i);
        }
        return ['to' => $toYears, 'from' => $fromYears];
    }

    public function indexAction()
    {
        $st = $this->batchModel->bind();
        $res = $st->getCollection();
        $years = $this->get10Years();
        $columns = array('Serial no', 'Name', 'From', 'To', 'Edit');
        $this->setTemplateVars(['batches' => $res, 'years' => $years, 'columns' => $columns, 'result' => $st->getPaginationSummary()]);
        $this->renderTemplate('Admin/Dashboard/Batch/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $batch = $this->batchModel->bind();
            $batch->setFromYear($_REQUEST['fromYear']);
            $batch->setToYear($_REQUEST['toYear']);
            $batch->setCode($_REQUEST['fromYear'] . "-" . $_REQUEST['toYear']);
            $batch->save();
            $this->setSuccessMessage("Batch created successfully");
        } else {
            $this->setErrorMessage("Unable to create Batch");
        }
        return $this->redirect('/admin/batch');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $batch = $this->batchModel->bind($_REQUEST['id']);
            $batch->setFromYear($_REQUEST['fromYear']);
            $batch->setToYear($_REQUEST['toYear']);
            $from = $_REQUEST['fromYear'];
            $to = $_REQUEST['toYear'];
            $batch->setCode($from . "-" . $to);
            if ($batch->save()) {
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
        $batch = $this->batchModel->bind($this->route_params['id']);
        $res = $batch->delete();
        if ($res) {
            $this->setSuccessMessage("Batch deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/batch');
    }
    public function editAction()
    {
        $st = $this->batchModel->bind($this->route_params['id']);
        $res = $st->get();
        $years = $this->get10Years();
        if ($res) {
            $this->setTemplateVars(['batch' => $res, 'years' => $years]);
            $this->renderTemplate('Admin/Dashboard/Batch/edit.html');
        } else {
            $this->redirect("/admin/teacher", ["message" => "Invalid Batch id!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $years = $this->get10Years();
        $this->setTemplateVars(['years' => $years]);
        $this->renderTemplate('Admin/Dashboard/Batch/new.html');

    }
}
