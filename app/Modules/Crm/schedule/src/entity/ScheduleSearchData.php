<?php
namespace App\Modules\Crm\schedule\src\entity;

use App\Modules\Crm\schedule\exceptions\SchedulePlanAddException;
use App\Src\BackendHelper;
use DateTime;

class ScheduleSearchData
{
    private $date_start;
    private $date_end;
    private $groups_id;
    private $specialties_id;

    public function __construct($data) {
        if (isset($data['date_start']) && isset($data['date_end'])) {
            $this->date_start = $data['date_start'];
            $this->date_end = $data['date_end'];
        } else {
            $this->date_start = BackendHelper::getOperations()->pacePeriod($data['period'])[0];
            $this->date_end = BackendHelper::getOperations()->pacePeriod($data['period'])[1];
        }

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
