<?php

namespace App\Helpers;

use App\Models\Department as DepartmentModel;

class Department
{

    public function __construct(DepartmentModel $departmentModel)
    {
        $this->departmentModel = $departmentModel;
    }

    public function create($department)
    {
        $departmentModel = $this->departmentModel->bind();
        $departmentModel->setDepartmentID($department['department']);
        $departmentModel->setName($department['name']);
        $departmentModel->setCode($department['code']);
        return $departmentModel->save();
    }

    public function update($department)
    {
        $departmentModel = $this->departmentModel->bind($department['id']);
        $departmentModel->setDepartmentID($department['department']);
        $departmentModel->setName($department['name']);
        $departmentModel->setCode($department['code']);
        return $departmentModel->save();
    }

    public function delete($id)
    {
        $departmentModel = $this->departmentModel->bind($id);
        return $departmentModel->delete();
    }

    public function getCollection($page)
    {
        $st = $this->departmentModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Department', 'HOD', 'Edit');
        return ['departments' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }
    public function getAll()
    {
        return ($this->departmentModel->bind())->getAll();
    }
    public function get($id)
    {
        $st = $this->departmentModel->bind($id);
        $res = $st->getCollection();
        $hods = $st->getTeachers();
        return ['department' => $res, 'hods' => $hods];
    }

}
