<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;

class Profile extends StudentController
{
    protected $pageCode = 'profile';

    public function indexAction()
    {
        $res = $this->student->getOneWithJoin();
        $achivementdetails = $this->student->getAchievementdetails();
        $certification = $this->student->getCertifications();
        $educationdetails = $this->student->getEducationdetails();
        $experiencedetails = $this->student->getExperiencedetails();
        $projects = $this->student->getProjects();
        $studentpersonaldetails = $this->student->getStudentpersonaldetatils();
        $this->setTemplateVars(['student' => $res, 'achivements' => $achivementdetails, 'certification' => $certification, 'educationdetails' => $educationdetails, 'experience' => $experiencedetails, 'projects' => $projects, 'studentpersonaldetails' => $studentpersonaldetails]);
        $this->renderTemplate('Student/Dashboard/Homepage/profile.html');
    }
}
