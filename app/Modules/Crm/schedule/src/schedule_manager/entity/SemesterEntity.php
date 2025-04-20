<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Entity\Semester;
use App\Modules\Crm\schedule\exceptions\HolidayException;
use App\Modules\Crm\schedule\src\schedule_manager\entity\units\SemesterUnit;
use App\Src\BackendHelper;

/** Сущность для работы с номерами пар */
class SemesterEntity
{
    /** @var array  */
    private $semesters;
    /** @var SemesterUnit[] $units */
    private $units;

    /**
     * @param Semester[] $semesters
     */
    public function __construct($semesters)
    {
        if (!$semesters) {
            throw new HolidayException('Нет семестра на этот период');
        }
        foreach ($semesters as $semester) {
            $this->semesters[$semester->id] = [
                'id' => $semester->id,
                'date_start' => $semester->date_start,
                'date_end' => $semester->date_end,
                'name' => $semester->name,
                'year_start' => $semester->year_start,
                'year_end' => $semester->year_end,
            ];
        }

    }

    public function getSemesters()
    {
        return $this->semesters;
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    public function getSemesterByDate($date)
    {
        foreach ($this->getSemesters() as $semester_date) {
            /** Предполагается что семестр будет найден */
            if (new \DateTime($semester_date['date_start']) <= $date && new \DateTime($semester_date['date_end']) >= $date) {
                return $semester_date;
            }
        }
    }

    /**
     * @param $semester
     * @param $group_id
     * @return void
     */
    public function loanSemestersUnit($semester, $group_id)
    {
        $type = BackendHelper::getRepositories()->getSchedulePlanTypeByGroupSemester($semester['id'], $group_id);
        $unit = new SemesterUnit(
            $semester['id'],
            $semester['date_start'],
            $semester['date_end'],
            $semester['name'],
            $semester['year_start'],
            $semester['year_end'],
            $group_id,
        );

        if ($type) {
            $unit->setTypePlanId($type->id);
            $unit->setTypePlanParam(json_decode($type->plan_type_data, 1));
        }
        $this->units[] = $unit;
    }

    /**
     * @param $group_id
     * @param $semester_id
     * @return SemesterUnit|void
     */
    public function getUnitByGroup($group_id, $semester_id)
    {
        foreach ($this->units as $unit) {
            if ($unit->getGroupId() == $group_id && $unit->getSemesterId() == $semester_id) {
                return $unit;
            }
        }
    }
}
