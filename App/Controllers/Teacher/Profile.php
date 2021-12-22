<?php

namespace App\Controllers\Teacher;

use App\Models\Teacher as TeacherModel;
class Profile extends TeacherController
{
    protected $pageCode = 'profile';

    public function __construct(
        TeacherModel $teacherModel
    ) {
        $this->teacherModel = $teacherModel;
        parent::__construct($teacherModel);
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
