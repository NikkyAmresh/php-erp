<?php

namespace App\Controllers\Admin;

use App\Helpers\TimeTable as TimeTableHelper;
use App\Models\Admin as AdminModel;

class TimeTable extends AdminController
{
    protected $pageCode = 'timetable';
    protected $adminModel;
    protected $timeTableHelper;

    public function __construct(
        AdminModel $adminModel,
        TimeTableHelper $timeTableHelper
    ) {
        $this->timeTableHelper = $timeTableHelper;
        parent::__construct($adminModel);
    }

    public function updateByClassAction()
    {
        $q1 = $this->timeTableHelper->deleteMany($_REQUEST['classID']);
        $q2 = $this->timeTableHelper->insertMulti($_REQUEST['data']);
        echo $q1 . $q2;

    }

    public function getAction()
    {
        $data = $this->timeTableHelper->get($this->route_params['id']);
        echo json_encode($res);
        return;
    }
    public function indexAction()
    {
        $data = $this->timeTableHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}
