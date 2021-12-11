<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Period as PeriodModel;

class Period extends AdminController
{
    protected $pageCode = 'period';
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $period = new PeriodModel();

            $period->setFromTime($_REQUEST['fromTime']);
            $period->setToTime($_REQUEST['toTime']);

            if ($period->save()) {
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
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['fromTime']))) {
            $period = new PeriodModel($_REQUEST['id']);

            $period->setFromTime($_REQUEST['fromTime']);
            $period->setToTime($_REQUEST['toTime']);
            if ($period->save()) {
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
        $period = new PeriodModel($this->route_params['id']);
        $res = $period->delete();
        if ($res) {
            $this->setSuccessMessage("Period delete successfully");
        } else {
            $this->setErrorMessage("Unable to create Period");
        }
        return $this->redirect('/admin/period');
    }

    public function indexAction()
    {
        $st = new PeriodModel();
        $res = $st->getAll();
        $columns = array('Serial no', 'from', 'to', 'Edit');
        $this->setTemplateVars(['periods' => $res, 'columns' => $columns]);
        $this->renderTemplate('Admin/Dashboard/Period/index.html');
    }
    public function editAction()
    {
        $st = new PeriodModel($this->route_params['id']);
        $res = $st->get();
        if ($res) {
            $this->setTemplateVars(['period' => $res]);
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