<?php

namespace App\Helpers\Models;

use App\Helpers\Models\Classes as ClassHelper;
use App\Models\Branch as BranchModel;
use App\Models\Classes as ClassModel;
use App\Models\Period as PeriodModel;
use App\Models\Student as StudentModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

class TimeTable extends ModelHelper
{
    protected $periodModel;
    protected $classModel;
    protected $subjectModel;
    protected $teacherModel;
    protected $timeTableModel;
    protected $branchModel;
    public function __construct(StudentModel $studentModel, ClassHelper $classHelper, ClassModel $classModel, PeriodModel $periodModel, SubjectModel $subjectModel, TeacherModel $teacherModel, TimeTableModel $timeTableModel, BranchModel $branchModel)
    {
        $this->branchModel = $branchModel;
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
        $this->teacherModel = $teacherModel;
        $this->timeTableModel = $timeTableModel;
        $this->classHelper = $classHelper;
        $this->studentModel = $studentModel;
        parent::__construct($timeTableModel);
    }

    public function updateByClass($data)
    {
        $timeTable = $this->timeTableModel->bind();
        $timeTable->deleteMany(['classID' => $data['classID']]);
        $timeTable->insertMulti($data['data']);
    }

    public function getCollection()
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
            $classRes[$key]['name'] = $this->classHelper->formatClassName($r);
        }
        return ['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes];
    }

    public function get($id)
    {
        $st = $this->classModel->bind($id);
        $res = $st->getTimeTable();
        return $res;
    }

    public function getAttendanceDetails($timeTableId, $teacherID)
    {
        $timeTable = $this->timeTableModel->bind(null, ['timetables.id' => $timeTableId, 'timetables.teacherID' => $teacherID, 'timetables.day' => lcfirst(date('l'))]);
        $res = $timeTable->get();
        if ($res) {
            $students = $timeTable->setStudent($this->studentModel)->getStudents();
            return ['timeTable' => $res, 'students' => $students];
        }else{
            return null;
        }
    }

}
