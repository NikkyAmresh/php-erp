<?php

namespace App\Helpers;
use App\Models\Student as StudentModel;
use App\Models\User as UserModel;

class Student extends User{

    public function __construct(StudentModel $studentModel,UserModel $userModel) {
        $this->studentModel = $studentModel;
        $this->userModel = $userModel;
        parent::__construct($userModel);
    }

    public function create($student)
    {
        if ($userId = $this->createUser($student)) {
            $studentModel = $this->studentModel->bind();
            $studentModel->setUserID($userId);
            $studentModel->setCourseID($student['course']);
            $studentModel->setBatchID($student['batch']);
            $studentModel->setClassID($student['class']);
            $studentModel->setRollNum($student['rollNum']);
            if ($id = $studentModel->save()) {
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
        $student = $this->studentModel->bind($id);
        $userId = $student->get()['userID'];
        $student->delete($id);
        return $this->deleteUser($userId);
    }
}