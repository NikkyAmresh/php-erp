<?php

namespace App\Helpers\Models;

use App\Models\Department as DepartmentModel;

class Department extends ModelHelper
{

    public function __construct(DepartmentModel $departmentModel)
    {
        $this->departmentModel = $departmentModel;
        parent::__construct($departmentModel);
    }

    public function create($department)
    {
        $departmentModel = $this->departmentModel->bind();
        $departmentModel->setName($department['name']);
        return $departmentModel->save();
    }

    public function update($department)
    {
        $departmentModel = $this->departmentModel->bind($department['id']);
        $departmentModel->setName($department['name']);
        if (isset($department['hod'])) {
            $departmentModel->setHodID($department['hod']);
        }
        return $departmentModel->save();
    }

    public function getCollection($page = 1)
    {
        $st = $this->departmentModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Department', 'HOD', 'Edit');
        return ['departments' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->departmentModel->bind($id);
        $res = $st->get();
        $hods = $st->getTeachers();
        return ['department' => $res, 'hods' => $hods];
    }

}
