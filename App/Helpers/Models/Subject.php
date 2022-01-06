<?php

namespace App\Helpers\Models;

use App\Models\Subject as SubjectModel;

class Subject extends ModelHelper
{

    public function __construct(SubjectModel $subjectModel)
    {
        $this->subjectModel = $subjectModel;
        parent::__construct($subjectModel);
    }

    public function create($subject)
    {
        $subjectModel = $this->subjectModel->bind();
        $subjectModel->setName($subject['name']);
        $subjectModel->setSubjectCode($subject['subjectCode']);
        $subjectModel->setDepartmentID($subject['department']);
        return $subjectModel->save();
    }

    public function update($subject)
    {
        $subjectModel = $this->subjectModel->bind($subject['id']);
        $subjectModel->setName($subject['name']);
        $subjectModel->setSubjectCode($subject['subjectCode']);
        $subjectModel->setDepartmentID($subject['department']);
        return $subjectModel->save();
    }

    public function getCollection($page = 1)
    {
        $st = $this->subjectModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'edit');
        return ['subjects' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }
}
