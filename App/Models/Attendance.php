<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $tableJOIN = 'SELECT
        attendances.*,users.name,classes.section,branches.name,branches.code,timetables.teacherID,teacherUser.name,timetables.day,periods.fromTime,periods.toTime,subjects.name,subjects.subjectCode
        FROM `attendances`
        join students on students.id=attendances.studentID
        join timetables on timetables.id=attendances.timeTableID
        join users on users.id=students.userID
        join teachers on timetables.teacherID=teachers.id
        join users as teacherUser on teachers.userID=teacherUser.id
        join subjects on subjects.id=timetables.subjectID
        join classes on classes.id=timetables.classID
        join departments on departments.id=classes.departmentID
        join branches on branches.id=classes.branchID
        join semesters on semesters.id=classes.semesterID
        join periods on timetables.periodID=periods.id';
    
    public function __construct(MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
