<?php

namespace App\Helpers\Models;

use App\Models\Period as PeriodModel;

class Period extends ModelHelper
{

    public function __construct(PeriodModel $periodModel)
    {
        $this->periodModel = $periodModel;
        parent::__construct($periodModel);
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

    public function getCollection($page)
    {
        $st = $this->periodModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'from', 'to', 'Edit');
        return ['periods' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

}
