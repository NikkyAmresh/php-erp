<?php

namespace App\Models;

class Student extends \Core\Model

{
    protected $table = 'students';

    protected $tableJOIN = 'SELECT students.*,users.name,users.mobile,users.id as userID,users.email, users.lastLogin,courses.name as courseName, courses.duration as courseDuration,batches.code as batchCode,batches.fromYear as batchFromYear, batches.toYear as batchToYear,semesters.name as semester,classes.section as section,branches.name as branchName,branches.code as branch, departments.name as department FROM `students` left join users on users.id=students.userID left join courses on courses.id=students.courseID left join batches on batches.id=students.batchID left join classes on classes.id=students.classID left join semesters on semesters.id=classes.semesterID left join branches on branches.id=classes.branchID left join departments on departments.id=branches.departmentID';


    public function __construct(
        User $userModel,
        TimeTable $timeTableModel,
        Attendance $attendanceModel,
        Certification $certificationModel,
        Achivementdetail $achivementdetailModel,
        Educationdetail $educationdetailModel,
        Experiencedetail $experiencedetailModel,
        Studentpersonaldetail $studentpersonaldetailModel,
        Project $projectModel,
        \MysqliDb $dbModel) {
        $this->userModel = $userModel;
        $this->experiencedetailModel = $experiencedetailModel;
        $this->timeTableModel = $timeTableModel;
        $this->attendanceModel = $attendanceModel;
        $this->certificationModel = $certificationModel;
        $this->achivementdetailModel = $achivementdetailModel;
        $this->educationdetailModel = $educationdetailModel;
        $this->StudentpersonaldetailModel = $studentpersonaldetailModel;
        $this->projectModel = $projectModel;
        parent::__construct($dbModel);
    }

    public function studentAuth($email, $pass)
    {
        $usr = $this->userModel->bind();
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
        $timeTable = $this->timeTableModel->bind(null, ['classID' => $this->getClassID()]);
        return $timeTable->getWithJoin();
    }

    public function getAllAttendance()
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId()]);
        return $attendance->getWithJoin();
    }

    public function getAttendanceBySubject($subjectCode)
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId(), 'subjects.subjectCode' => $subjectCode]);
        return $attendance->getWithJoin();
    }

    public function getAttendanceByDay($day)
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId(), 'date' => $day]);
        return $attendance->getWithJoin();

    }

    public function getCertifications()
    {
        $certification = $this->certificationModel->bind(null, ['userID' => $this->getUserID()]);
        return $certification->getAll();
    }
    public function getAchievementdetails()
    {
        $achivementdetails = $this->achivementdetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $achivementdetails->getAll();
    }
    public function getEducationdetails()
    {
        $educationdetails = $this->educationdetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $educationdetails->getAll();
    }
    public function getExperiencedetails()
    {
        $experiencedetails = $this->experiencedetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $experiencedetails->getAll();
    }
    public function getProjects()
    {
        $projects = $this->projectModel->bind(null, ['userID' => $this->getUserID()]);
        return $projects->getAll();
    }
    public function getStudentpersonaldetatils()
    {
        $studentpersonaldetails = $this->studentpersonaldetailModel->bind(null, ['studentID' => $this->getId()]);
        return $studentpersonaldetails->getOneWithJoin();
    }
}
