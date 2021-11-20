<?php

namespace App\Controllers\Teacher;

use App\Models\Period;
use \Core\View;

class TimeTable extends TeacherController
{

    public function getAction()
    {
        $res = $this->teacher->getTimeTable();
        echo json_encode($res);
        return;
    }
    public function showAction()
    {
        $periods = (new Period())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        View::renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html', ['periods' => $periods, 'days' => $days]);
    }
}
