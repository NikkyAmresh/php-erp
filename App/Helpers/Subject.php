<?php

namespace App\Helpers;

use App\Models\Subject as SubjectModel;

class Subject
{

    public function __construct(SubjectModel $subjectModel)
    {
        $this->subjectModel = $subjectModel;
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

    public function delete($id)
    {
        $subjectModel = $this->subjectModel->bind($id);
        return $subjectModel->delete();
    }

    public function getCollection()
    {
        $st = $this->subjectModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'edit');
        return ['subjects' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->subjectModel->bind($id);
        return $st->get();
    }

}
