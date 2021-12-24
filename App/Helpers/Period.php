<?php

namespace App\Helpers;

use App\Models\Period as PeriodModel;

class Period
{

    public function __construct(PeriodModel $periodModel)
    {
        $this->periodModel = $periodModel;
    }

    public function create($period)
    {
        $periodModel = $this->periodModel->bind();
        $periodModel->setFromTime($period['fromTime']);
        $periodModel->setToTime($period['toTime']);
        return $periodModel->save();
    }

    public function update($period)
    {
        $periodModel = $this->periodModel->bind($period['id']);
        $periodModel->setFromTime($period['fromTime']);
        $periodModel->setToTime($period['toTime']);
        return $periodModel->save();
    }

    public function delete($id)
    {
        $periodModel = $this->periodModel->bind($id);
        return $periodModel->delete();
    }

    public function getCollection()
    {
        $st = $this->periodModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'from', 'to', 'Edit');
        return ['periodes' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->periodModel->bind($id);
        $res = $st->getCollection();
        return ['period' => $res];
    }

}
