<?php
namespace App\Modules\Crm\holidays\repositories;


use App\Entity\Holiday;
use App\Entity\ScheduleTask;
use App\Modules\Crm\schedule\src\schedule_manager\entity\HolidayEntity;
use App\Src\BackendHelper;
use App\Src\modules\repository\Repository;

class HolidayRepository extends Repository{


    /**
     * Создает запись о празднике
     * @param $name
     * @param $period
     * @param $week_days
     * @param $format_id
     * @param $description
     * @return Holiday|void
     */
    public function createHoliday($name, $date_start, $date_end, $week_days, $format_id, $description = null)
    {
        $holiday = new Holiday();
        $holiday->name = $name;
        $holiday->date_start = $date_start;
        $holiday->date_end = $date_end;
        $holiday->week_days = $week_days;
        $holiday->format_id = $format_id;
        $holiday->description = $description;
        if ($holiday->save()) {
            return $holiday;
        }
    }

    /**
     * Возвращает все праздничные дни
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllHolidays()
    {
        return Holiday::orderBy('date_end', 'desc')->get();
    }

    /**
     * Получает праздник по id
     * @param $id
     * @return mixed
     */
    public function getHolidayById($id)
    {
        return Holiday::where(['id'=>$id])->first();
    }

    /**
     * Обновляет запись о празднике
     * @param $id
     * @param $name
     * @param $period
     * @param $week_days
     * @param $format_id
     * @param $description
     * @return Holiday|void
     */
    public function editHoliday($id, $name, $date_start, $date_end, $week_days, $format_id, $description = null)
    {
        $holiday = BackendHelper::getRepositories()->getHolidayById($id);
        $holiday->name = $name;
        $holiday->date_start = $date_start;
        $holiday->date_end = $date_end;
        $holiday->week_days = $week_days;
        $holiday->format_id = $format_id;
        $holiday->description = $description;
        if ($holiday->save()) {
            return $holiday;
        }
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function deleteHoliday($id)
    {
        $holiday = BackendHelper::getRepositories()->getHolidayById($id);
        return $holiday->delete();
    }

    /**
     * Возвращает праздники по дате
     * @param string $date
     * @return Holiday
     */
    public function getHolidayByDate($date)
    {
        return Holiday::where(['date_start', '<=', $date], ['date_end', '>=', $date])->first();
    }
}
