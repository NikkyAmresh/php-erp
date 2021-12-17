<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Teacher;

class Profile extends TeacherController
{
    protected $pageCode = 'profile';

    public function indexAction()
    {
        $achivementdetails = $this->teacher->getAchievementdetails();
        $certification = $this->teacher->getCertifications();
        $experiencedetails = $this->teacher->getExperiencedetails();
        $projects = $this->teacher->getProjects();
        $res = $this->teacher->getOneWithJoin();
        $this->setTemplateVars(['teacher' => $res, 'achivements' => $achivementdetails, 'certification' => $certification, 'experience' => $experiencedetails, 'projects' => $projects]);
        $this->renderTemplate('Teacher/Dashboard/profile.html');
    }
}
