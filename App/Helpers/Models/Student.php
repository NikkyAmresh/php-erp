<?php

namespace App\Helpers\Models;

use App\Helpers\Models\Classes as ClassHelper;
use App\Models\Batch as BatchModel;
use App\Models\Classes as ClassModel;
use App\Models\Course as CourseModel;
use App\Models\Student as StudentModel;
use App\Models\User as UserModel;

class Student extends User
{
    public function __construct(StudentModel $studentModel, UserModel $userModel, CourseModel $courseModel, ClassModel $classModel, BatchModel $batchModel, ClassHelper $classHelper)
    {
        $this->studentModel = $studentModel;
        $this->userModel = $userModel;
        $this->courseModel = $courseModel;
        $this->classModel = $classModel;
        $this->batchModel = $batchModel;
        $this->classHelper = $classHelper;
        parent::__construct($userModel, $studentModel);
    }


    public function create($student)
    {
        $user = $this->userModel->bind();
        $user->setName($student['name']);
        $user->setMobile($student['mobile']);
        $user->setEmail($student['email']);
        $user->setPassword(md5($student['password']));
        $studentModel = $this->studentModel->bind();
        if ($id = $user->save()) {
            $studentModel->setUserID($id);
            $studentModel->setCourseID($student['course']);
            $studentModel->setBatchID($student['batch']);
            $studentModel->setClassID($student['class']);
            $studentModel->setRollNum($student['rollNum']);
            return $studentModel->save();
        }

    }

    public function update($student)
    {
        if ($student['userID']) {
            $user = $this->userModel->bind();
            $user->get($student['userID']);
            $user->setName($student['name']);
            $user->setMobile($student['mobile']);
            $user->setEmail($student['email'])->save();
        }
        $studentModel = $this->studentModel->bind();
        $studentModel->get($student['id']);
        $studentModel->setCourseID($student['course']);
        $studentModel->setBatchID($student['batch']);
        $studentModel->setClassID($student['class']);
        $studentModel->setRollNum($student['rollNum']);
        return $studentModel->save();
    }
    public function getCollection($page)
    {
        $st = $this->studentModel->bind(null, null, ['users.id', 'asc'], $page);
        $res = $st->getCollection();
        $columns = array('Serial no.', 'Roll no.', 'Name', 'Mobile', 'Email', 'Batch', 'Course', 'Branch', 'Semester', 'Edit');
        return [
            'columns' => $columns,
            'students' => $res,
            'result' => $st->getPaginationSummary(),
        ];
    }
}
