<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;

use App\Entity\PairNumber;
use App\Entity\Semester;
use App\Modules\Crm\schedule\exceptions\ScheduleManagerException;

/** Сущность для работы с номерами пар */
class SemesterEntity
{
    /** @var array  */
    private $semesters;

    /**
     * @param Semester[] $semesters
     */
    public function __construct($semesters)
    {
        if (!$semesters) {
            throw new ScheduleManagerException('Нет семестра на этот период');
        }
        foreach ($semesters as $semester) {
            $this->semesters[] = [
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
}
