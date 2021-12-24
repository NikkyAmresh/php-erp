<?php

namespace App\Helpers;

use App\Models\Classes as ClassModel;

class Classes
{

    public function __construct(ClassModel $classModel)
    {
        $this->classModel = $classModel;
    }
    public function className($array)
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

    public function delete($id)
    {
        $classModel = $this->classModel->bind($id);
        return $classModel->delete();
    }

    public function getCollection()
    {
        $st = $this->classModel->bind(null, null, ['semester', 'asc']);
        $res = $st->getCollection();
        $columns = array('Serial no', 'Name', 'Class Teacher', 'Edit');
        $sections = $this->getSections();
        foreach ($res as $key => $r) {
            $res[$key]['name'] = $this->className($r);
        }
        return [
            'columns' => $columns,
            'classes' => $res,
            'sections' => $sections,
            'result' => $st->getPaginationSummary(),
        ];
    }

    public function get($id)
    {
        $st = $this->classModel->bind($id);
        return $st->get();
    }

}
