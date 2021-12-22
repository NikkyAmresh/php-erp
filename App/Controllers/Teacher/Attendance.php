<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
// use App\Models\Attendance as AttendanceModel;
use App\Models\Attendance as AttendanceModel;
use App\Models\Classes as ClassModel;
use App\Models\Period as PeriodModel;
use App\Models\Student as StudentModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

class Attendance extends TeacherController
{
    protected $pageCode = 'attendance';

    public function __construct(
        TimeTableModel $timeTableModel,
        SubjectModel $subjectModel,
        PeriodModel $periodModel,
        ClassModel $classModel,
        TeacherModel $teacherModel,
        StudentModel $studentModel,
        AttendanceModel $attendanceModel
    ) {
        $this->timeTableModel = $timeTableModel;
        $this->subjectModel = $subjectModel;
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->teacherModel = $teacherModel;
        $this->studentModel = $studentModel;
        $this->attendanceModel = $attendanceModel;
        parent::__construct($teacherModel);
    }
    public function indexAction()
    {
        $st = $this->timeTableModel->bind();
        $res = $st->getCollection();
        $subjects = $this->subjectModel->bind();
        $subRes = $subjects->getAll();
        $periods = $this->periodModel->bind()->getAll();
        $classes = $this->classModel->bind();
        $classRes = $classes->getCollection();
        $teacher = $this->teacherModel->bind();
        $teacherRes = $teacher->getCollection();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        $this->setTemplateVars(['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/index.html');
    }

    public function markAction()
    {
        $timeTableId=$this->route_params['id'];
        $timeTable = $this->timeTableModel->bind(null, ['timetables.id' => $timeTableId, 'timetables.teacherID' => $this->teacher->getId(), 'timetables.day' => lcfirst(date('l'))]);
        $res = $timeTable->get();
        $students = $timeTable->setStudent($this->studentModel)->getStudents();
        $date = date("Y/m/d");
        $attendance = $this->attendanceModel->bind(null,['date'=>$date,'timetableID'=>$timeTableId])->getCollection();
        $this->setTemplateVars(['ets' => json_encode($res), 'timeTable' => $res, 'students' => $students,'attendance'=>$attendance]);
        $this->renderTemplate('Teacher/Dashboard/Attendance/index.html');
        return;
    }

    public function submitAttendanceAction()
    {
        $timeTableId = $_POST['timetableID'];
        $attendances = $_POST['attendances'];

        $attendance = $this->attendanceModel->bind();

        $timeTable = $this->timeTableModel->bind(null, ['timetables.id' => $timeTableId, 'timetables.teacherID' => $this->teacher->getId(), 'timetables.day' => lcfirst(date('l'))]);
        $docs = [];
        $date = date("Y/m/d");
        foreach ($attendances as $value) {
            $doc = ['studentID'=>$value['id'],'status'=>$value['status'],'date'=>$date,'timetableID'=>$timeTableId];
            array_push($docs,$doc);
        }
        $res = false;
        try {
            $res = $timeTable->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
        if($res){
            $attendance->deleteMany(['date'=>$date,'timetableID'=>$timeTableId]);
            if($attendance->insertMulti($docs)){
                return $this->renderMessage(1,"Attendance Updated");
            }else{
                return $this->renderMessage(0,"Somethig went Wrong");
            }
        }else{
            return $this->renderMessage(0,"You are not allowed to mark this date/subject attendace");
        }


    }
    public function showAction()
    {
        $periods = $this->periodModel->bind()->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}
