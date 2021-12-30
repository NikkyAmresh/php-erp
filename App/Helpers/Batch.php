<?php

namespace App\Helpers;

use App\Models\Batch as BatchModel;

class Batch
{

    public function __construct(BatchModel $batchModel)
    {
        $this->batchModel = $batchModel;
    }

    public function create($batch)
    {
        $batchModel = $this->batchModel->bind();
        $batchModel->setFromYear($batch['fromYear']);
        $batchModel->setToYear($batch['toYear']);
        $batchModel->setCode($batch['fromYear'] . "-" . $batch['toYear']);
        return $batchModel->save();
    }

    public function update($batch)
    {
        $batchModel = $this->batchModel->bind($batch['id']);
        $batchModel->setFromYear($batch['fromYear']);
        $batchModel->setToYear($batch['toYear']);
        $from = $batch['fromYear'];
        $to = $batch['toYear'];
        $batchModel->setCode($from . "-" . $to);
        return $batchModel->save();
    }

    public function delete($id)
    {
        $batch = $this->batchModel->bind($id);
        return $batch->delete();
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
        $st = $this->batchModel->bind()->setPage($page);
        $res = $st->getCollection();
        $years = $this->get10Years();
        $columns = array('Serial no', 'Name', 'From', 'To', 'Edit');
        return ['batches' => $res, 'years' => $years, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->batchModel->bind($id);
        return $st->get();
    }

}
