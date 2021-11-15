<?php

 namespace App\Controllers\Admin;

 use App\Models\Batch as BatchModel;
 use \Core\View;
 use App\Helpers\Constants;

 class Batch extends \Core\Controller
 {
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }

    public function get10Years()
    {
         $currentYear = date("Y");
         $fromYears = array();
         $toYears = array();
         for ($i=0; $i < 11; $i++) { 
             array_push($fromYears,$currentYear-$i);
             array_push($toYears,$currentYear+$i);
         }
         return array('to'=>$toYears,'from'=>$fromYears);
    }

    public function indexAction()
    {
        $st = new BatchModel();
        $res = $st->getAll();
        $years = $this->get10Years();
        View::renderTemplate('Admin/Dashboard/Batch/index.html', array('batches' => $res,'years'=>$years));
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $batch = new BatchModel();
            $batch->setFromYear($_REQUEST['fromYear']);
            $batch->setToYear($_REQUEST['toYear']);
            $batch->setCode($_REQUEST['fromYear']."-".$_REQUEST['toYear']);
            $batch->save();
            $this->setSuccessMessage("Batch created successfully");
        }
        else {
             $this->setErrorMessage("Unable to create Batch");
            }
        return $this->redirect('/admin/batches');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            $batch = new BatchModel();
            $batch->get($_REQUEST['id']);
            $batch->setFromYear($_REQUEST['fromYear']);
            $batch->setToYear($_REQUEST['toYear']);
            $from = $_REQUEST['fromYear'];
            $to = $_REQUEST['toYear'];
            $batch->setCode($from."-".$to);
            if ($batch->save()) {
                $this->setSuccessMessage("Batch updated successfully");
            } else {
                $this->setErrorMessage("Unable to create batch");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/batches');
    }

    public function deleteAction()
    {
        $batch = new BatchModel();
        $res = $batch->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("Batch deleted successfully");
        } else {
            $this->setErrorMessage("Unable to delete");
        }
        return $this->redirect('/admin/batches');
    }
    public function editAction()
    {
        $st = new BatchModel();
        $res = $st->get($this->route_params['id']);
        $years = $this->get10Years();
        if ($res) {
            View::renderTemplate('Admin/Dashboard/Batch/edit.html', ['batch' => $res,'years'=>$years]);
        } else {
            $this->redirect("/admin/teacher", array("message" => "Invalid Batch id!", 'type' => Constants::ERROR));
        }
    }
 }
 