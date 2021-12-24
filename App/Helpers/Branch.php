<?php

namespace App\Helpers;

use App\Models\Branch as BranchModel;

class Branch
{

    public function __construct(BranchModel $branchModel)
    {
        $this->branchModel = $branchModel;
    }

    public function create($branch)
    {
        $branchModel = $this->branchModel->bind();
        $branchModel->setDepartmentID($branch['department']);
        $branchModel->setName($branch['name']);
        $branchModel->setCode($branch['code']);
        return $branchModel->save();
    }

    public function update($branch)
    {
        $branchModel = $this->branchModel->bind($branch['id']);
        $branchModel->setDepartmentID($branch['department']);
        $branchModel->setName($branch['name']);
        $branchModel->setCode($branch['code']);
        return $branchModel->save();
    }

    public function delete($id)
    {
        $branchModel = $this->branchModel->bind($id);
        return $branchModel->delete();
    }

    public function getCollection()
    {
        $st = $this->branchModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'Edit');
        return ['branches' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

    public function get($id)
    {
        $st = $this->branchModel->bind($id);
        return $st->get();
    }

}
