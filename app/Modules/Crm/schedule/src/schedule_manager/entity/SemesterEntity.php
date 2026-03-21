<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Entity\Semester;
use App\Modules\Crm\schedule\exceptions\HolidayException;
use App\Modules\Crm\schedule\src\schedule_manager\entity\units\SemesterUnit;
use App\Src\BackendHelper;

/** Сущность для работы с семестрами */
class SemesterEntity
{
    /** @var array  */
    private $semesters = [];
    /** @var SemesterUnit[] $units */
    private $units = [];

    /**
     * @param Semester[] $semesters
     */
    public function __construct($semesters)
    {
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

    public function getSemesters(): array
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
}
