<?php

namespace App\Models;

class Student extends \Core\Model

{
    protected $table = 'students';

    protected $tableJOIN = 'SELECT students.*,users.name,users.mobile,users.id as userID,users.email, users.lastLogin,courses.name as courseName, courses.duration as courseDuration,batches.code as batchCode,batches.fromYear as batchFromYear, batches.toYear as batchToYear,semesters.name as semester,classes.section as section,branches.name as branchName,branches.code as branch, departments.name as department FROM `students` left join users on users.id=students.userID left join courses on courses.id=students.courseID left join batches on batches.id=students.batchID left join classes on classes.id=students.classID left join semesters on semesters.id=classes.semesterID left join branches on branches.id=classes.branchID left join departments on departments.id=branches.departmentID';

    public function studentAuth($email, $pass)
    {
        $usr = new User();
        $validate = $usr->auth($email, $pass);
        if ($validate) {
            $student = $this->db->where('userID', $usr->getUser()['id'])->getOne($this->table);
            if ($student) {
                $this->user = $usr->getUser();
                $this->student = $student;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getStudentUser()
    {
        return $this->student;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTimeTable()
    {
        $timeTable = new TimeTable(null, ['field' => 'classID', 'value' => $this->getClassID()]);
        return $timeTable->getWithJoin();
    }

    public function getAllAttendance()
    {
        $attendance = new Attendance(null, ['field' => 'studentID', 'value' => $this->getId()]);
        return $attendance->getWithJoin();
    }

    public function getAttendanceBySubject($subjectCode)
    {
        $attendance = new Attendance(null, [['field' => 'studentID', 'value' => $this->getId()], ['field' => 'subjects.subjectCode', 'value' => $subjectCode]]);
        return $attendance->getWithJoin();
    }

    public function getAttendanceByDay($day)
    {
        $attendance = new Attendance(null, [['field' => 'studentID', 'value' => $this->getId()], ['field' => 'date', 'value' => $day]]);
        return $attendance->getWithJoin();

    }

    public function getCertifications()
    {
        $certification = new Certification(null, [['field' => 'userID', 'value' => $this->getUserID()]]);
        return $certification->getAll();
    }
    public function getAchievementdetails()
    {
        $achivementdetails = new Achivementdetail(null, [['field' => 'userID', 'value' => $this->getUserID()]]);
        return $achivementdetails->getAll();
    }
    public function getEducationdetails()
    {
        $educationdetails = new Educationdetail(null, [['field' => 'userID', 'value' => $this->getUserID()]]);
        return $educationdetails->getAll();
    }
    public function getExperiencedetails()
    {
        $experiencedetails = new Experiencedetail(null, [['field' => 'userID', 'value' => $this->getUserID()]]);
        return $experiencedetails->getAll();
    }
    public function getProjects()
    {
        $projects = new Project(null, [['field' => 'userID', 'value' => $this->getUserID()]]);
        return $projects->getAll();
    }
    public function getStudentpersonaldetatils()
    {
        $studentpersonaldetails = new Studentpersonaldetail(null, [['field' => 'studentID', 'value' => $this->getId()]]);
        return $studentpersonaldetails->getOneWithJoin();
    }
}
