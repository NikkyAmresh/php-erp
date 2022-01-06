<?php

namespace App\Helpers\Models;

use App\Models\Batch as BatchModel;

class Batch extends ModelHelper
{

    public function __construct(BatchModel $model)
    {
        parent::__construct($model);
    }

    public function create($batch)
    {
        $batchModel = $this->model->bind();
        $batchModel->setFromYear($batch['fromYear']);
        $batchModel->setToYear($batch['toYear']);
        $batchModel->setCode($batch['fromYear'] . "-" . $batch['toYear']);
        return $batchModel->save();
    }

    public function update($batch)
    {
        $batchModel = $this->model->bind($batch['id']);
        $batchModel->setFromYear($batch['fromYear']);
        $batchModel->setToYear($batch['toYear']);
        $from = $batch['fromYear'];
        $to = $batch['toYear'];
        $batchModel->setCode($from . "-" . $to);
        return $batchModel->save();
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

    public function getCollection($page)
    {
        $st = $this->model->bind()->setPage($page);
        $res = $st->getCollection();
        $years = $this->get10Years();
        $columns = array('Serial no', 'Name', 'From', 'To', 'Edit');
        return ['batches' => $res, 'years' => $years, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

}
