<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Classes as ClassModel;
use App\Models\Period as PeriodModel;
use App\Models\Student as StudentModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;
use \Core\View;

class Attendance extends TeacherController
{
    protected $pageCode = 'attendance';

    public function __construct(
        TimeTableModel $timeTableModel,
        SubjectModel $subjectModel,
        PeriodModel $periodModel,
        ClassModel $classModel,
        TeacherModel $teacherModel,
        StudentModel $studentModel
    ) {
        $this->timeTableModel = $timeTableModel;
        $this->subjectModel = $subjectModel;
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->teacherModel = $teacherModel;
        $this->studentModel = $studentModel;
        parent::__construct($teacherModel);
    }
    public function indexAction()
    {
        $st = $this->timeTableModel->bind();
        $res = $st->getWithJoin();
        $subjects = $this->subjectModel->bind();
        $subRes = $subjects->getAll();
        $periods = ($this->periodModel->bind())->getAll();
        $classes = $this->classModel->bind();
        $classRes = $classes->getWithJoin();
        $teacher = $this->teacherModel->bind();
        $teacherRes = $teacher->getWithJoin();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($classRes as $key => $r) {
            $classRes[$key]['name'] = $this->className($r);
        }
        View::renderTemplate('Teacher/Dashboard/TimeTable/index.html', ['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes]);
    }

    public function markAction()
    {
        $timeTable = $this->timeTableModel->bind(null, ['timetables.id' => $this->route_params['id'], 'timetables.teacherID' => $this->teacher->getId(), 'timetables.day' => lcfirst(date('l'))]);
        $res = $timeTable->getOneWithJoin();
        $students = $timeTable->setStudent($this->studentModel)->getStudents();
        $this->setTemplateVars(['ets' => json_encode($res), 'timeTable' => $res, 'students' => $students]);
        $this->renderTemplate('Teacher/Dashboard/Attendance/index.html');
        return;
    }

    public function submitAttendanceAction()
    {
        $timeTableId = $_POST['timetableID'];
        $attendances = $_POST['attendances'];
        $timeTable = $this->timeTable->bind(null, ['timetables.id' => $timeTableId, 'timetables.teacherID' => $this->teacher->getId(), 'timetables.day' => lcfirst(date('l'))]);
        $res = $timeTable->get();

    }
    public function showAction()
    {
        $periods = ($this->periodModel->bind())->getAll();
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $this->setTemplateVars(['periods' => $periods, 'days' => $days]);
        $this->renderTemplate('Teacher/Dashboard/TimeTable/TimeTable.html');
    }
}
