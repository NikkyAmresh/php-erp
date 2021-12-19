<?php

namespace App\Models;

use Core\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $tableJOIN = 'SELECT teachers.*,departments.name as department,users.name as name,users.email as email,users.mobile as mobile FROM `teachers` join departments on departments.id=teachers.departmentID left JOIN users on users.id = teachers.userID';


    public function __construct(
        User $userModel,
        TimeTable $timeTableModel,
        Certification $certificationModel,
        Achivementdetail $achivementdetailModel,
        Experiencedetail $experiencedetailModel,
        Project $projectModel,
        \MysqliDb $dbModel) {
        $this->userModel = $userModel;
        $this->experiencedetailModel = $experiencedetailModel;
        $this->timeTableModel = $timeTableModel;
        $this->certificationModel = $certificationModel;
        $this->achivementdetailModel = $achivementdetailModel;
        $this->projectModel = $projectModel;
        parent::__construct($dbModel);
    }
    public function teacherAuth($email, $pass)
    {
        $usr = $this->userModel->bind();
        $validate = $usr->auth($email, $pass);
        if ($validate) {
            $teacher = $this->db->where('userID', $usr->getUser()['id'])->getOne($this->table);
            if ($teacher) {
                $this->user = $usr->getUser();
                $this->teacher = $teacher;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getTeacherUser()
    {
        return $this->teacher;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTimeTable()
    {
        $timeTable = $this->timeTableModel->bind(null, ['timetables.teacherID' => $this->getId()]);
        return $timeTable->getWithJoin();
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
}
