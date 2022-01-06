<?php

namespace App\Controllers\Admin;

use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Models\TimeTable as TimeTableHelper;

class TimeTable extends AdminController
{
    protected $pageCode = 'timetable';
    protected $adminHelper;
    protected $timeTableHelper;

    public function __construct(
        AdminHelper $adminHelper,
        TimeTableHelper $timeTableHelper
    ) {
        $this->timeTableHelper = $timeTableHelper;
        parent::__construct($adminHelper);
    }

    public function updateByClassAction()
    {
        $this->timeTableHelper->updateByClass($_REQUEST);
        echo true;

    }

    public function getAction()
    {
        $data = $this->timeTableHelper->get($this->route_params['id']);
        echo json_encode($data);
        return;
    }
    public function indexAction()
    {
        $data = $this->timeTableHelper->getCollection();
        $this->setTemplateVars($data);
        $this->renderTemplate('Admin/Dashboard/TimeTable/index.html');
    }
}
