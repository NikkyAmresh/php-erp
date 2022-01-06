<?php

namespace App\Helpers\Models;

use App\Models\Teacher as TeacherModel;
use App\Models\User as UserModel;

class Teacher extends User
{

    public function __construct(TeacherModel $teacherModel, UserModel $userModel)
    {
        $this->teacherModel = $teacherModel;
        $this->userModel = $userModel;
        parent::__construct($userModel, $teacherModel);
    }

    public function create($teacher)
    {
        $userModel = $this->userModel->bind();
        $userModel->setName($teacher['name']);
        $userModel->setMobile($teacher['mobile']);
        $userModel->setEmail($teacher['email']);
        $userModel->setPassword(md5($teacher['password']));
        if ($id = $userModel->save()) {
            $teacherModel = $this->teacherModel->bind();
            $teacherModel->setUserID($id);
            $teacherModel->setDepartmentID($teacher['department']);
            return $teacherModel->save();
        } else {
            return null;
        }
    }
    public function update($teacher)
    {
        $teacherModel = $this->teacherModel->bind($teacher['id']);
        $teacherModel->get();
        if ($teacher['userID']) {
            $userModel = $this->userModel->bind();
            $userModel->get($teacher['userID']);
            $userModel->setName($teacher['name'])->save();
        }
        $teacherModel->setDepartmentID($_REQUEST['department']);
        return $teacherModel->save();
    }

    public function getCollection($page = 1)
    {
        $st = $this->teacherModel->bind()->setPage($page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Department', 'Edit');
        return ['teachers' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }
}
