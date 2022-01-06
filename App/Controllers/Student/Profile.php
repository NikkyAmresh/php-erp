<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Helpers\Models\Student as StudentHelper;

class Profile extends StudentController
{
    protected $pageCode = 'profile';
    protected $personalDetail;
    protected $studentController;
    protected $studentHelper;

    /**
     * Class constructor.
     */
    public function __construct(StudentHelper $studentHelper)
    {
        parent::__construct($studentHelper);
    }

    public function indexAction()
    {
        $res = $this->student->get();
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
