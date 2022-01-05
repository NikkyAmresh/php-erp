<?php

namespace App\Helpers;

use App\Models\Course as CourseModel;

class Course
{

    public function __construct(CourseModel $courseModel)
    {
        $this->courseModel = $courseModel;
    }

    public function create($course)
    {
        $courseModel = $this->courseModel->bind();
        $courseModel->setName($course['name']);
        $courseModel->setDuration($course['duration']);
        return $courseModel->save();
    }

    public function update($course)
    {
        $courseModel = $this->courseModel->bind($course['id']);
        $courseModel->setName($course['name']);
        $courseModel->setDuration($course['duration']);
        return $courseModel->save();
    }

    public function delete($id)
    {
        $courseModel = $this->courseModel->bind($id);
        return $courseModel->delete();
    }

    public function getCollection($page)
    {
        $st = $this->courseModel->bind()->setPage($page);
        $res = $st->getAll();
        $columns = array('Serial no', 'Course', 'Duration', 'Edit');
        return ['courses' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->courseModel->bind($id);
        return $st->getCollection();
    }

}
