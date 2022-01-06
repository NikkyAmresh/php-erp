<?php

namespace App\Helpers\Models;

use App\Models\Attendance as AttendanceModel;

class Attendance extends ModelHelper
{

    public function __construct(AttendanceModel $attendanceModel)
    {
        $this->attendanceModel = $attendanceModel;
        parent::__construct($attendanceModel);
    }

    public function markAttendance($timeTableId, $attendances)
    {
        $docs = [];
        $date = date("Y/m/d");
        foreach ($attendances as $value) {
            $doc = ['studentID' => $value['id'], 'status' => $value['status'], 'date' => $date, 'timetableID' => $timeTableId];
            array_push($docs, $doc);
        }
        $attendanceModel->deleteMany(['date' => $date, 'timetableID' => $timeTableId]);
        return $attendanceModel->insertMulti($docs);
    }

}
