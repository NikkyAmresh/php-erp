<?php

namespace App\Helpers\Models;

use App\Models\Classes as ClassModel;

class Classes extends ModelHelper
{

    public function __construct(ClassModel $classModel)
    {
        $this->classModel = $classModel;
        parent::__construct($classModel);
    }
    public function formatClassName($array)
    {
        $result = preg_replace("/[^0-9]+/", "", $array['semester']);
        $year = ceil($result / 2);
        return $array['branch'] . ' (' . $year . ")year [sem - ${array['semester']}] | section " . ucfirst($array['section']);
    }

    public function getSections()
    {
        return [
            ['id' => 'a', 'code' => 'A'],
            ['id' => 'b', 'code' => 'B'],
            ['id' => 'c', 'code' => 'C'],
            ['id' => 'd', 'code' => 'D'],
        ];
    }
    public function create($class)
    {
        $classModel = $this->classModel->bind();
        $classModel->setDepartmentID($class['department']);
        $classModel->setBranchID($class['branch']);
        $classModel->setSemesterID($class['semester']);
        $classModel->setSection($class['section']);
        $classModel->setTeacherID($class['teacher']);
        return $classModel->save();
    }

    public function update($class)
    {
        $classModel = $this->classModel->bind($class['id']);
        $classModel->setDepartmentID($class['department']);
        $classModel->setBranchID($class['branch']);
        $classModel->setSemesterID($class['semester']);
        $classModel->setSection($class['section']);
        $classModel->setTeacherID($class['teacher']);
        return $classModel->save();
    }

    public function getCollection($page = 1)
    {
        $st = $this->classModel->bind(null, null, ['semester', 'asc'], $page);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Class Teacher', 'Edit');
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->formatClassName($r);
        }
        return [
            'columns' => $columns,
            'classes' => $res,
            'sections' => $sections,
            'result' => $st->getPaginationSummary(),
        ];
    }

}
