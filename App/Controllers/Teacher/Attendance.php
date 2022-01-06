<?php

namespace App\Controllers\Teacher;

use App\Helpers\Models\Attendance as AttendanceHelper;
use App\Helpers\Models\Teacher as TeacherHelper;
use App\Helpers\Models\TimeTable as TimeTableHelper;

class Attendance extends TeacherController
{
    protected $pageCode = 'attendance';

    public function __construct(
        TimeTableHelper $timeTableHelper,
        TeacherHelper $teacherHelper,
        AttendanceHelper $attendanceHelper
    ) {
        $this->timeTableHelper = $timeTableHelper;
        $this->teacherHelper = $teacherHelper;
        $this->attendanceHelper = $attendanceHelper;
        parent::__construct($teacherHelper);
    }

    public function markAction()
    {
        $timeTableId = $this->route_params['id'];
        $res = $this->timeTableHelper->getAttendanceDetails($timeTableId, $this->teacher->getId());
        if(!$res){
            $this->setErrorMessage("You are not allowed to mark this date/subject attendace");
            $this->redirect("/teacher/timeTable");
            return;
        }
        $students = $res['students'];
        $timeTable = $res['timeTable'];
        $date = date("Y/m/d");
        $attendance = $this->attendanceHelper->getAll(['date' => $date, 'timetableID' => $timeTableId]);
        $this->setTemplateVars(['ets' => json_encode($res), 'timeTable' => $timeTable, 'students' => $students, 'attendance' => $attendance]);
        $this->renderTemplate('Teacher/Dashboard/Attendance/index.html');
        return;
    }

    public function submitAttendanceAction()
    {
        $timeTableId = $_POST['timetableID'];
        $attendances = $_POST['attendances'];

        $timeTable = $this->timeTableHelper->getAll(['timetables.id' => $timeTableId, 'timetables.teacherID' => $this->teacher->getId(), 'timetables.day' => lcfirst(date('l'))]);
        if (count($timeTable)) {
            if ($this->attendanceHelper->markAttendance($timeTableId, $attendances)) {
                return $this->renderMessage(1, "Attendance Updated");
            } else {
                return $this->renderMessage(0, "Somethig went Wrong");
            }
        } else {
            return $this->renderMessage(0, "You are not allowed to mark this date/subject attendace");
        }

    }
}
