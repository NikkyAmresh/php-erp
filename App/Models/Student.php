<?php

namespace App\Models;

class Student extends \Core\Model
{
    protected static $table = 'students';

    protected static $tableJOIN = 'SELECT students.*,users.name,users.email,users.phone, users.lastLogin,courses.name as courseName, courses.duration as courseDuration,batches.code as batchCode,batches.fromYear as batchFromYear, batches.toYear as batchToYear,semesters.name as semester,classes.section as section,branches.name as branchName,branches.code as branch, departments.name as department FROM `students` left join users on users.id=students.userID left join courses on courses.id=students.courseID left join batches on batches.id=students.batchID left join semesters on semesters.id=students.semesterID left join classes on classes.id=students.classID left join branches on branches.id=classes.branchID left join departments on departments.id=branches.departmentID';
}
