<?php

namespace App\Helpers;

use App\Models\Semester as SemesterModel;

class Semester
{

    public function __construct(SemesterModel $semesterModel)
    {
        $this->semesterModel = $semesterModel;
    }

    public function create($semester)
    {
        $semester = $this->semesterModel->bind();
        $semester->setName($semester['name']);
        return $semester->save();
    }

    public function update($semester)
    {
        $semester = $this->semesterModel->bind();
        $semester->setName($semester['name']);
        return $semester->save();
    }

    public function delete($id)
    {
        $semesterModel = $this->semesterModel->bind($id);
        return $semesterModel->delete();
    }

    public function getCollection()
    {
        $st = $this->semesterModel->bind();
        $res = $st->getAll();
        $columns = array('Serial no', 'Name', 'Edit');
        return ['semesters' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->semesterModel->bind($id);
        $res = $st->get();
        return ['semester' => $res];
    }

}
