<?php

namespace App\Models;

use Core\Model;

class Period extends Model
{
    protected static $table = 'periods';
    protected static $tableJOIN = 'SELECT periods.*,classes.*,subjects.*,dept.name as department,branches.name as branch,sem.name as semester,sem.id as semesterID,users.name as teacher from periods join classes on periods.classID=classes.id join subjects on periods.subjectID=subjects.id join departments as dept on subjects.departmentID=dept.id join branches on classes.branchID=branches.id join semesters as sem on classes.semesterID=sem.id join users on periods.teacherID=users.id';

}
