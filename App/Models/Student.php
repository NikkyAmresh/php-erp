<?php

namespace App\Models;

use \MysqliDb;

class Student extends \Core\Model

{
    protected $table = 'students';
    protected $tableJOIN = 'SELECT students.*,users.name,users.mobile,users.id as userID,users.email, users.lastLogin,courses.name as courseName, courses.duration as courseDuration,batches.code as batchCode,batches.fromYear as batchFromYear, batches.toYear as batchToYear,semesters.name as semester,classes.section as section,branches.name as branchName,branches.code as branch, departments.name as department FROM `students` left join users on users.id=students.userID left join courses on courses.id=students.courseID left join batches on batches.id=students.batchID left join classes on classes.id=students.classID left join semesters on semesters.id=classes.semesterID left join branches on branches.id=classes.branchID left join departments on departments.id=branches.departmentID';
    protected $userModel;
    protected $timeTableModel;
    protected $attendanceModel;
    protected $certificationModel;
    protected $achivementDetailModel;
    protected $educationDetailModel;
    protected $experienceDetailModel;
    protected $studentPersonalDetailModel;
    protected $projectModel;
    protected $dbModel;

    public function __construct(
        MysqliDb $dbModel,
        User $userModel,
        TimeTable $timeTableModel,
        Attendance $attendanceModel,
        Certification $certificationModel,
        AchivementDetail $achivementdetailModel,
        EducationDetail $educationdetailModel,
        ExperienceDetail $experiencedetailModel,
        StudentPersonalDetail $studentpersonaldetailModel,
        Project $projectModel) {
        $this->userModel = $userModel;
        $this->experienceDetailModel = $experiencedetailModel;
        $this->timeTableModel = $timeTableModel;
        $this->attendanceModel = $attendanceModel;
        $this->certificationModel = $certificationModel;
        $this->achivementDetailModel = $achivementdetailModel;
        $this->educationDetailModel = $educationdetailModel;
        $this->studentPersonalDetailModel = $studentpersonaldetailModel;
        $this->projectModel = $projectModel;
        $this->dbModel = $dbModel;
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
        return $timeTable->getCollection();
    }

    public function getAllAttendance()
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId()]);
        return $attendance->getCollection();
    }

    public function getAttendanceBySubject($subjectCode)
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId(), 'subjects.subjectCode' => $subjectCode]);
        return $attendance->getCollection();
    }

    public function getAttendanceByDay($day)
    {
        $attendance = $this->attendanceModel->bind(null, ['studentID' => $this->getId(), 'date' => $day]);
        return $attendance->getCollection();

    }

    public function getCertifications()
    {
        $certification = $this->certificationModel->bind(null, ['userID' => $this->getUserID()]);
        return $certification->getAll();
    }
    public function getAchievementDetails()
    {
        $achivementDetails = $this->achivementDetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $achivementDetails->getAll();
    }
    public function getEducationDetails()
    {
        $educationDetails = $this->educationDetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $educationDetails->getAll();
    }
    public function getExperienceDetails()
    {
        $experienceDetails = $this->experienceDetailModel->bind(null, ['userID' => $this->getUserID()]);
        return $experienceDetails->getAll();
    }
    public function getProjects()
    {
        $projects = $this->projectModel->bind(null, ['userID' => $this->getUserID()]);
        return $projects->getAll();
    }
    public function getStudentPersonalDetatils()
    {
        $studentpersonalDetails = $this->studentPersonalDetailModel->bind(null, ['studentID' => $this->getId()]);
        return $studentpersonalDetails->get();
    }
}
