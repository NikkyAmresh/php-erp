<?php

namespace App\Controllers\Teacher;

use App\Helpers\Models\Teacher as TeacherHelper;

class Profile extends TeacherController
{
    protected $pageCode = 'profile';

    public function __construct(
        TeacherHelper $teacherHelper
    ) {
        $this->teacherHelper = $teacherHelper;
        parent::__construct($teacherHelper);
    }

    public function indexAction()
    {
        $achivementDetails = $this->teacher->getAchievementDetails();
        $certification = $this->teacher->getCertifications();
        $experienceDetails = $this->teacher->getExperienceDetails();
        $projects = $this->teacher->getProjects();
        $res = $this->teacher->get();
        $this->setTemplateVars(['teacher' => $res, 'achivements' => $achivementDetails, 'certification' => $certification, 'experience' => $experienceDetails, 'projects' => $projects]);
        $this->renderTemplate('Teacher/Dashboard/profile.html');
    }
}
