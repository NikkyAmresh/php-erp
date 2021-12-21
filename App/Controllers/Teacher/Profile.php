<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Teacher;

class Profile extends TeacherController
{
    protected $pageCode = 'profile';

    public function indexAction()
    {
        $achivementDetails = $this->teacher->getAchievementDetails();
        $certification = $this->teacher->getCertifications();
        $experienceDetails = $this->teacher->getExperienceDetails();
        $projects = $this->teacher->getProjects();
        $res = $this->teacher->getOneWithJoin();
        $this->setTemplateVars(['teacher' => $res, 'achivements' => $achivementDetails, 'certification' => $certification, 'experience' => $experienceDetails, 'projects' => $projects]);
        $this->renderTemplate('Teacher/Dashboard/profile.html');
    }
}
