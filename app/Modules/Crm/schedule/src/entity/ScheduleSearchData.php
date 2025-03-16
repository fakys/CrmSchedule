<?php
namespace App\Modules\Crm\schedule\src\entity;

use App\Modules\Crm\schedule\exceptions\ScheduleEditException;
use App\Src\BackendHelper;
use DateTime;

class ScheduleSearchData
{
    private $date_start;
    private $date_end;
    private $groups_id;
    private $specialties_id;

    public function __construct($data) {
        $this->date_start = BackendHelper::getOperations()->pacePeriod($data['period'])[0];
        $this->date_end = BackendHelper::getOperations()->pacePeriod($data['period'])[1];
        $this->groups_id = $data['groups'] ?? null;
        $this->specialties_id = $data['specialties'] ?? null;
    }

    public function getDateStart()
    {
        return $this->date_start;
    }

    public function getDateEnd()
    {
        return $this->date_end;
    }

    public function getGroupsId()
    {
        return $this->groups_id;
    }

    public function getSpecialtiesId()
    {
        return $this->specialties_id;
    }
}
