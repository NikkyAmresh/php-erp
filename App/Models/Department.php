<?php

namespace App\Models;

use App\Models\Teacher;
use Core\Model;
use Core\MysqliDb;

class Department extends Model
{
    protected $table = 'departments';
    protected $tableJOIN = 'SELECT departments.*,users.name as hod FROM `departments` left join teachers on teachers.id=departments.hodID left join users on users.id=teachers.userID';
    protected $teacherModel;
    protected $dbModel;

    public function __construct(Teacher $teacherModel, MysqliDb $dbModel)
    {
        $this->teacherModel = $teacherModel;
        parent::__construct($dbModel);
    }

    public function getTeachers()
    {
        $st = $this->teacherModel->bind(null, ['departmentID' => $this->id]);
        return $st->getCollection();
    }

}
