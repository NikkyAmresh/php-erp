<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Models\Period;
use \Core\View;

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
        View::renderTemplate('Student/Dashboard/TimeTable/TimeTable.html', ['periods' => $periods, 'days' => $days]);
    }
}
