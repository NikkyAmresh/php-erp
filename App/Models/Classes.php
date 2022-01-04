<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class Classes extends Model
{
    protected $table = 'classes';
    protected $tableJOIN = 'SELECT classes.*,departments.name as department,branches.name as brancheName,branches.code as branch,semesters.name as semester, users.name as teacher FROM `classes` left join departments on departments.id=classes.departmentID left join branches on branches.id=classes.branchID left join semesters on semesters.id=classes.semesterID join teachers on classes.teacherID=teachers.id join users on users.id=teachers.userID';

    public function __construct(Student $studentModel, TimeTable $timeTableModel,MysqliDb $dbModel) {
        $this->studentModel = $studentModel;
        $this->timeTableModel = $timeTableModel;
        parent::__construct($dbModel);
    }

    public function getStudents()
    {
        $st = $this->studentModel->bind(null, ['classID' => $this->id]);
        return $st->getCollection();
    }

    public function getTimeTable()
    {
        $st = $this->timeTableModel->bind(null, ['classID' => $this->id]);
        return $res = $st->getCollection();
    }
}
