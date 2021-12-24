<?php

namespace App\Helpers;

use App\Models\Teacher as TeacherModel;
use App\Models\User as UserModel;

class Teacher extends User
{

    public function __construct(TeacherModel $teacherModel, UserModel $userModel)
    {
        $this->teacherModel = $teacherModel;
        $this->userModel = $userModel;
        parent::__construct($userModel);
    }

    public function get($id)
    {
        return $this->teacherModel->bind($id)->get();
    }

    public function create($teacher)
    {
        $teacherModel = $this->userModel->bind();
        $teacherModel->setName($teacher['name']);
        $teacherModel->setMobile($teacher['mobile']);
        $teacherModel->setEmail($teacher['email']);
        $teacherModel->setPassword(md5($teacher['password']));
        if ($id = $teacherModel->save()) {
            $teacher = $this->teacherModel->bind();
            $teacher->setUserID($id);
            $teacher->setDepartmentID($_REQUEST['department']);
            return $teacher->save();
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

    public function delete($id)
    {
        $teacher = $this->teacherModel->bind($id);
        $userId = $teacher->get()['userID'];
        $teacher->delete($id);
        return $this->deleteUser($userId);
    }
    public function getCollection()
    {
        $st = $this->teacherModel->bind();
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Department', 'Edit');
        return ['teachers' => $res, 'columns' => $columns, 'result' => $st->getPaginationSummary()];
    }
    public function getAll($id)
    {
        $teacherModel = $this->teacherModel->bind($id);
        return $teacherModel->get();
    }
}
