<?php

namespace App\Helpers;
use App\Models\Teacher as TeacherModel;
use App\Models\User as UserModel;

class Teacher extends User{

    public function __construct(TeacherModel $teacherModel,UserModel $userModel) {
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
        if ($userId = $this->createUser($teacher)) {
            $teacherModel = $this->teacherModel->bind();
            $teacherModel->setUserID($userId);
            $teacherModel->setDepartmentID($teacher['departmentID']);
            if ($id = $teacherModel->save()) {
                return $id;
            } else {
                return null;
                $this->deleteUser($userId);
            }
        }
        return null;
    }

    public function delete($id)
    {
        $teacher = $this->teacherModel->bind($id);
        $userId = $teacher->get()['userID'];
        $teacher->delete($id);
        return $this->deleteUser($userId);
    }
}