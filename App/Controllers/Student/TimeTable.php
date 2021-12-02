<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Models\Period;

class TimeTable extends StudentController
{
    public function getAction()
    {
        $res = $this->student->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Student/Dashboard/TimeTable/TimeTable.html');
    }
}
