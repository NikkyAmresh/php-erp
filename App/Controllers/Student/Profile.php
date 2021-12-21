<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Models\Student as StudentModel;

class Profile extends StudentController
{
    protected $pageCode = 'profile';
    protected $personalDetail;
    protected $studentController;
    protected $studentModel;

    /**
     * Class constructor.
     */
    public function __construct(StudentModel $studentModel)
    {
        parent::__construct($studentModel);
    }

    public function indexAction()
    {
        $res = $this->student->getOneWithJoin();
        $achivementDetails = $this->student->getAchievementDetails();
        $certification = $this->student->getCertifications();
        $educationDetails = $this->student->getEducationDetails();
        $experienceDetails = $this->student->getExperienceDetails();
        $projects = $this->student->getProjects();
        $studentPersonalDetails = $this->student->getStudentPersonalDetatils();
        $this->setTemplateVars(['student' => $res, 'achivements' => $achivementDetails, 'certification' => $certification, 'educationdetails' => $educationDetails, 'experience' => $experienceDetails, 'projects' => $projects, 'studentpersonaldetails' => $studentPersonalDetails]);
        $this->renderTemplate('Student/Dashboard/Homepage/profile.html');
    }
}
