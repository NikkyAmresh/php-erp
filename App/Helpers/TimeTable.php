<?php

namespace App\Helpers;

use App\Models\Branch as BranchModel;
use App\Models\Classes as ClassModel;
use App\Models\Period as PeriodModel;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher as TeacherModel;
use App\Models\TimeTable as TimeTableModel;

class Branch
{
    protected $periodModel;
    protected $classModel;
    protected $subjectModel;
    protected $teacherModel;
    protected $timeTableModel;
    protected $branchModel;
    public function __construct(ClassModel $classModel, PeriodModel $periodModel, SubjectModel $subjectModel, TeacherModel $teacherModel, TimeTableModel $timeTableModel, BranchModel $branchModel)
    {
        $this->branchModel = $branchModel;
        $this->periodModel = $periodModel;
        $this->classModel = $classModel;
        $this->subjectModel = $subjectModel;
        $this->teacherModel = $teacherModel;
        $this->timeTableModel = $timeTableModel;
    }

    public function create($branch)
    {
        $branchModel = $this->branchModel->bind();
        $branchModel->setDepartmentID($branch['department']);
        $branchModel->setName($branch['name']);
        $branchModel->setCode($branch['code']);
        return $branchModel->save();
    }

    public function update($branch)
    {
        $branchModel = $this->branchModel->bind($branch['id']);
        $branchModel->setDepartmentID($branch['department']);
        $branchModel->setName($branch['name']);
        $branchModel->setCode($branch['code']);
        return $branchModel->save();
    }

    public function delete($id)
    {
        $branchModel = $this->branchModel->bind($id);
        return $branchModel->delete();
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
            $classRes[$key]['name'] = $this->className($r);
        }
        return ['timeTables' => $res, 'periods' => $periods, 'subjects' => $subRes, 'classes' => $classRes, 'days' => $days, 'teachers' => $teacherRes];
    }

    public function get($id)
    {
        $st = $this->branchModel->bind($id);
        return $st->get();
    }

}
