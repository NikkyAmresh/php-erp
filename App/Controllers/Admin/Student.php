<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Admin as AdminModel;
use App\Models\Batch as BatchModel;
use App\Models\Classes as ClassesModel;
use App\Models\Course as CourseModel;
use App\Models\Student as StudentModel;
use App\Models\User as UserModel;

class Student extends AdminController
{

    protected $pageCode = 'student';
    protected $adminModel;
    protected $class;
    protected $course;
    protected $student;
    protected $user;
    protected $batch;
    public function __construct(
        AdminModel $adminModel,
        ClassesModel $class,
        BatchModel $batch,
        StudentModel $student,
        UserModel $user,
        CourseModel $course
    ) {
        $this->batch = $batch;
        $this->student = $student;
        $this->user = $user;
        $this->class = $class;
        $this->course = $course;
        parent::__construct($adminModel);
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
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {

            $user = $this->user->bind();
            $user->setName($_REQUEST['name']);
            $user->setMobile($_REQUEST['mobile']);
            $user->setEmail($_REQUEST['email']);
            $user->setPassword(md5($_REQUEST['password']));
            if ($id = $user->save()) {
                $student = $this->student->bind();
                $student->setUserID($id);
                $student->setCourseID($_REQUEST['course']);
                $student->setBatchID($_REQUEST['batch']);
                $student->setClassID($_REQUEST['class']);
                $student->setRollNum($_REQUEST['rollNum']);
                if ($student->save()) {
                    $this->setSuccessMessage("Student {$_REQUEST['name']} created successfully");
                } else {
                    $user = $this->user->bind();
                    $this->setErrorMessage($student->getError());
                    $user->delete($id);
                }
            } else {
                $this->setErrorMessage("Unable to create Student");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/student');
    }
    public function updateAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {
            if ($_REQUEST['userID']) {
                $user = $this->user->bind();
                $user->get($_REQUEST['userID']);
                $user->setName($_REQUEST['name']);
                $user->setMobile($_REQUEST['mobile']);
                $user->setEmail($_REQUEST['email'])->save();
            }
            $student = $this->student->bind();
            $student->get($_REQUEST['id']);
            $student->setCourseID($_REQUEST['course']);
            $student->setBatchID($_REQUEST['batch']);
            $student->setClassID($_REQUEST['class']);
            $student->setRollNum($_REQUEST['rollNum']);
            if ($student->save()) {
                $this->setSuccessMessage("Student {$_REQUEST['name']} updated successfully");
            } else {
                $this->setErrorMessage("Unable to update Student");
            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/student');
    }

    public function deleteAction()
    {
        $student = $this->student->bind($this->route_params['id']);
        $res = $student->delete();
        if ($res) {
            $this->setSuccessMessage("Student delete successfully");
        } else {
            $this->setErrorMessage("Unable to delete Student");
        }
        return $this->redirect('/admin/student');
    }

    public function indexAction()
    {
        $page = 1;
        if (isset($this->route_params['page'])) {
            $page = $this->route_params['page'];
        }
        $st = $this->student->bind(null, null, ['users.id', 'asc'], $page);
        $res = $st->getWithJoin();
        $columns = array('Serial no.', 'Roll no.', 'Name', 'Mobile', 'Email', 'Batch', 'Course', 'Branch', 'Semester', 'Edit');
        $this->setTemplateVars([
            'columns' => $columns,
            'students' => $res,
            'result' => $st->result(),
        ]);
        $this->renderTemplate('Admin/Dashboard/Student/index.html');
    }
    public function editAction()
    {
        $st = $this->student->bind($this->route_params['id']);
        $res = $st->getOneWithJoin();
        if ($res) {
            $courseModel = $this->course->bind();
            $courses = $courseModel->getWithJoin();
            $batchesModel = $this->batch->bind();
            $batches = $batchesModel->getWithJoin();
            $classes = ($this->class->bind())->getWithJoin(null, null, ['semester', 'asc']);
            foreach ($classes as $key => $r) {
                $classes[$key]['name'] = $this->className($r);
            }
            $this->setTemplateVars([
                'student' => $res,
                'courses' => $courses,
                'batches' => $batches,
                'classes' => $classes,
            ]);
            $this->renderTemplate('Admin/Dashboard/Student/edit.html');
        } else {
            $this->redirect("/admin/student", ["message" => "Invalid StudentID!", 'type' => Constants::ERROR]);
        }
    }
    public function newAction()
    {
        $courses = ($this->course->bind())->getWithJoin();
        $batches = ($this->batch->bind())->getWithJoin();
        $classes = ($this->class->bind())->getWithJoin(null, null, null, ['semester', 'asc']);
        foreach ($classes as $key => $r) {
            $classes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars([
            'courses' => $courses,
            'batches' => $batches,
            'classes' => $classes,
        ]);
        $this->renderTemplate('Admin/Dashboard/Student/new.html');
    }
}
