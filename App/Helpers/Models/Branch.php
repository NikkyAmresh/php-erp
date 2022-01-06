<?php

namespace App\Helpers\Models;

use App\Models\Branch as BranchModel;

class Branch extends ModelHelper
{

    public function __construct(BranchModel $branchModel)
    {
        $this->branchModel = $branchModel;
        parent::__construct($branchModel);
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

    public function getCollection($page)
    {
        $st = $this->branchModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Code', 'Department', 'Edit');
        return ['branches' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }

}
