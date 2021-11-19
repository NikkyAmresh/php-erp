<?php

namespace App\Models;

use Core\Model;

class TimeTable extends Model
{
    protected static $table = 'timetables';
    protected static $tableJOIN = 'SELECT timetables.*,
    departments.name as department,
    departments.id as departmentID,
    branches.name as branch,
    branches.code as branchCode,
    branches.id as branchID,
    classes.section as section,
    semesters.name as semester,
    semesters.id as semesterID,
    users.name as teacher,
    users.id as teacherUserID,
    periods.fromTime,
    periods.toTime,
    subjects.subjectCode,
    subjects.name as subjectName from timetables
    join periods on periods.id=timetables.periodID
    join classes on timetables.classID=classes.id
    join departments on departments.id=classes.departmentID
    join branches on branches.id=classes.branchID
    join semesters on semesters.id=classes.semesterID
    join teachers on timetables.teacherID=teachers.id
    join users on users.id=teachers.userID
    join subjects on timetables.subjectID=subjects.id
'
    ;

}
