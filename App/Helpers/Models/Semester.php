<?php

namespace App\Helpers\Models;

use App\Models\Semester as SemesterModel;

class Semester extends ModelHelper
{

    public function __construct(SemesterModel $semesterModel)
    {
        $this->semesterModel = $semesterModel;
        parent::__construct($semesterModel);
    }

    public function create($semester)
    {
        $semesterModel = $this->semesterModel->bind();
        $semesterModel->setName($semester['name']);
        return $semesterModel->save();
    }

    public function update($semester)
    {
        $semesterModel = $this->semesterModel->bind($semester['id']);
        $semesterModel->setName($semester['name']);
        return $semesterModel->save();
    }

    public function getCollection($page = 1)
    {
        $st = $this->semesterModel->bind()->setPage($page);
        $res = $st->getAll();
        $columns = array('Serial no', 'Name', 'Edit');
        return ['semesters' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

}
