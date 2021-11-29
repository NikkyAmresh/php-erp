<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Batch as BatchModel;

class Batch extends AdminController
{
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
        $st = new BatchModel();
        $res = $st->getAll();
        $years = $this->get10Years();
        $this->setTemplateVars(['batches' => $res, 'years' => $years]);
        $this->renderTemplate('Admin/Dashboard/Batch/index.html');
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $batch = new BatchModel();
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
            $batch = new BatchModel($_REQUEST['id']);
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
        $batch = new BatchModel($this->route_params['id']);
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
        $st = new BatchModel($this->route_params['id']);
        $res = $st->get();
        $years = $this->get10Years();
        if ($res) {
            $this->setTemplateVars(['batch' => $res, 'years' => $years]);
            $this->renderTemplate('Admin/Dashboard/Batch/edit.html');
        } else {
            $this->redirect("/admin/teacher", ["message" => "Invalid Batch id!", 'type' => Constants::ERROR]);
        }
    }
}
