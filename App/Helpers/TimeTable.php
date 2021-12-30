<?php

namespace App\Helpers;

use App\Helpers\Classes as ClassHelper;
use App\Models\Branch as BranchModel;
use App\Models\Classes as ClassModel;
use App\Models\Period as PeriodModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

class TimeTable
{
    protected $periodModel;
    protected $classModel;
    protected $subjectModel;
    protected $teacherModel;
    protected $timeTableModel;
    protected $branchModel;
    public function __construct(ClassHelper $classHelper, ClassModel $classModel, PeriodModel $periodModel, SubjectModel $subjectModel, TeacherModel $teacherModel, TimeTableModel $timeTableModel, BranchModel $branchModel)
    {
        $this->branchModel = $branchModel;
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
        $this->teacherModel = $teacherModel;
        $this->timeTableModel = $timeTableModel;
        $this->classHelper = $classHelper;
    }

    public function deleteMany($classId)
    {
        $timeTable = $this->timeTableModel->bind();
        return $timeTable->deleteMany(['classID' => $classId]);
    }
    public function insertMulti($data)
    {
        $timeTable = $this->timeTableModel->bind();
        return $timeTable->insertMulti($data);
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

}
