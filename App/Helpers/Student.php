<?php

namespace App\Helpers;

use App\Models\Batch as BatchModel;
use App\Models\Classes as ClassModel;
use App\Models\Course as CourseModel;
use App\Models\Student as StudentModel;
use App\Models\User as UserModel;

class Student extends User
{
    public function __construct(StudentModel $studentModel, UserModel $userModel, CourseModel $courseModel, ClassModel $classModel, BatchModel $batchModel)
    {
        $this->studentModel = $studentModel;
        $this->userModel = $userModel;
        $this->courseModel = $courseModel;
        $this->classModel = $classModel;
        $this->batchModel = $batchModel;
        parent::__construct($userModel);
    }
    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function getSections()
    {
        return [
            ['id' => 'a', 'code' => 'A'],
            ['id' => 'b', 'code' => 'B'],
            ['id' => 'c', 'code' => 'C'],
            ['id' => 'd', 'code' => 'D'],
        ];
    }

    public function get($id)
    {
        return $this->studentModel->bind($id)->get();
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
    public function delete($id)
    {
        $student = $this->studentModel->bind($id);
        $userId = $student->get()['userID'];
        $student->delete($id);
        return $this->deleteUser($userId);
    }
    public function get($id)
    {
        $st = $this->studentModel->bind($id);
        $res = $st->get();
        if ($res) {
            $courseModel = $this->courseModel->bind();
            $courses = $courseModel->getCollection();
            $batchesModel = $this->batchModel->bind();
            $batches = $batchesModel->getCollection();
            $classes = $this->classModel->bind(null, null, ['semester', 'asc'])->getCollection();
            foreach ($classes as $key => $r) {
                $classes[$key]['name'] = $this->className($r);
            }
            return [
                'student' => $res,
                'courses' => $courses,
                'batches' => $batches,
                'classes' => $classes,
            ];
        }

    }
    public function getCollectionForNew()
    {
        $courses = $this->courseModel->bind()->getCollection();
        $batches = $this->batchModel->bind()->getCollection();
        $classes = $this->classModel->bind(null, null, ['semester', 'asc'])->getCollection();
        foreach ($classes as $key => $r) {
            $classes[$key]['name'] = $this->className($r);

        }
        return [
            'courses' => $courses,
            'batches' => $batches,
            'classes' => $classes,
        ];

    }
}
