<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Models\Batch;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Student as StudentModel;
use App\Models\User;
use \Core\View;

class Student extends AdminController
{

    public function className($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function getSections()
    {
        return array(
            array('id' => 'a', 'code' => 'A'),
            array('id' => 'b', 'code' => 'B'),
            array('id' => 'c', 'code' => 'C'),
            array('id' => 'd', 'code' => 'D'),
        );
    }
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST && !empty(trim($_REQUEST['name']))) {

            $user = new User();
            $user->setName($_REQUEST['name']);
            $user->setMobile($_REQUEST['mobile']);
            $user->setEmail($_REQUEST['email']);
            $user->setPassword(md5($_REQUEST['password']));
            if ($id = $user->save()) {
                $student = new StudentModel();
                $student->setUserID($id);
                $student->setCourseID($_REQUEST['course']);
                $student->setBatchID($_REQUEST['batch']);
                $student->setClassID($_REQUEST['class']);
                $student->setRollNum($_REQUEST['rollNum']);
                if ($student->save()) {
                    $this->setSuccessMessage("Student {$_REQUEST['name']} created successfully");
                } else {
                    $user = new User();
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
                $user = new User();
                $user->get($_REQUEST['userID']);
                $user->setName($_REQUEST['name']);
                $user->setMobile($_REQUEST['mobile']);
                $user->setEmail($_REQUEST['email'])->save();
            }
            $student = new StudentModel();
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
        $student = new StudentModel();
        $res = $student->delete($this->route_params['id']);
        if ($res) {
            $this->setSuccessMessage("Student delete successfully");
        } else {
            $this->setErrorMessage("Unable to delete Student");
        }
        return $this->redirect('/admin/student');
    }

    public function indexAction()
    {
        $st = new StudentModel();
        $res = $st->getWithJoin(null, null, null, array('users.name', 'asc'));
        $courses = (new Course())->getWithJoin();
        $batches = (new Batch())->getWithJoin();
        $classes = (new Classes())->getWithJoin(null, null, null, array('semester', 'asc'));
        foreach ($classes as $key => $r) {
            $classes[$key]['name'] = $this->className($r);
        }
        View::renderTemplate('Admin/Dashboard/Student/index.html', array(
            'students' => $res,
            'courses' => $courses,
            'batches' => $batches,
            'classes' => $classes,
        ));
    }
    public function editAction()
    {
        $st = new StudentModel();
        $res = $st->getOneWithJoin($this->route_params['id']);
        if ($res) {
            $courses = (new Course())->getWithJoin();
            $batches = (new Batch())->getWithJoin();
            $classes = (new Classes())->getWithJoin(null, null, null, array('semester', 'asc'));
            foreach ($classes as $key => $r) {
                $classes[$key]['name'] = $this->className($r);
            }
            View::renderTemplate('Admin/Dashboard/Student/edit.html', array(
                'student' => $res,
                'courses' => $courses,
                'batches' => $batches,
                'classes' => $classes,
            ));
        } else {
            $this->redirect("/admin/student", array("message" => "Invalid StudentID!", 'type' => Constants::ERROR));
        }
    }
}
