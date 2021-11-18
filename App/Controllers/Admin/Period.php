<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Period as PeriodModel;
use \Core\View;

class Period extends AdminController
{
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
            $period = new PeriodModel();
            $period->get($_REQUEST['id']);

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
        $period = new PeriodModel();
        $res = $period->delete($this->route_params['id']);
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
        View::renderTemplate('Admin/Dashboard/Period/index.html', array('periods' => $res));
    }
    public function editAction()
    {
        $st = new PeriodModel();
        $res = $st->get($this->route_params['id']);
        if ($res) {
            View::renderTemplate('Admin/Dashboard/Period/edit.html', array('period' => $res));
        } else {
            $this->redirect("/admin/period", array("message" => "Invalid TecherID!", 'type' => Constants::ERROR));
        }
    }
}
