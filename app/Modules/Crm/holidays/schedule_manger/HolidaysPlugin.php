<?php
namespace App\Modules\Crm\holidays\schedule_manger;

use App\Entity\Holiday;
use App\Modules\Crm\schedule\schedule_manger\plugins\abstracts\AbstractSchedulePlugin;
use App\Modules\Crm\schedule\src\schedule_manager\entity\HolidayEntity;
use App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit;


/**
 * Плагин назначающий каникулы
 */
class HolidaysPlugin extends AbstractSchedulePlugin
{

    public function getTag()
    {
        return 'schedule_manger';
    }

    public function getName(): string
    {
        return 'holidays_plugin';
    }

    public function index()
    {
        return 1;
    }

    public function Execute()
    {
//        if (BackendHelper::getKernel()->getModuleByName('holidays')->getStatus()) {
//            $this->holiday_setting = BackendHelper::getSystemSettings('holiday_settings');
//            $this->all_holidays = BackendHelper::getRepositories()->getAllHolidays();
//            if ($this->schedule) {
//                if ($this->holiday_setting->use_settings) {
//                    if (
//                        $this->holiday_setting->use_priority_setting &&
//                        $this->holiday_setting->priority_setting &&
//                        $this->holiday_setting->replace_no_priority_setting
//                    ) {
//                        switch ($this->holiday_setting->priority_setting) {
//                            case HolidaySetting::MAIN_SETTING:
//                                foreach ($this->schedule->getScheduleUnits() as $unit) {
//                                    $this->setHolidayByDate($unit);
//                                    $this->setHolidaySettings($unit, true);
//                                }
//                                break;
//                            default:
//                                foreach ($this->schedule->getScheduleUnits() as $unit) {
//                                    $this->setHolidaySettings($unit);
//                                    $this->setHolidayByDate($unit, true);
//                                }
//                                break;
//                        }
//                    } else {
//                        switch ($this->holiday_setting->priority_setting){
//                            case HolidaySetting::MAIN_SETTING:
//                                foreach ($this->schedule->getScheduleUnits() as $unit) {
//                                    $this->setHolidayByDate($unit);
//                                    $this->setHolidaySettings($unit);
//                                }
//                                break;
//                            default:
//                                foreach ($this->schedule->getScheduleUnits() as $unit) {
//                                    $this->setHolidaySettings($unit);
//                                    $this->setHolidayByDate($unit);
//                                }
//                                break;
//                        }
//                    }
//                }
//            }
//        }
    }


    /**
     * @param array $holiday_data
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     * @return HolidayEntity
     */
    public function createHoliday($holiday_data, $date_start, $date_end)
    {
        $holiday = new HolidayEntity();
        $holiday->setHolidayName($holiday_data['name']);
        $holiday->setHolidayDescription($holiday_data['description']);
        if (isset($holiday_data['format'])) {
            $holiday->setHolidayFormatType($holiday_data['format']);
        } else {
            $holiday->setHolidayFormatType($holiday_data['format_id']);
        }

        $holiday->setHolidayDateStart($date_start);
        $holiday->setHolidayDateEnd($date_end);
        return $holiday;
    }

    /**
     * Возвращает праздники по дате
     * @param \DateTime $date
     * @return Holiday
     */
    public function getHolidayByDate($date)
    {
        if ($this->all_holidays) {
            foreach ($this->all_holidays as $holiday){
                if (new \DateTime($holiday->date_start)>=$date && new \DateTime($holiday->date_end)<=$date) {
                    return $holiday;
                }
            }
        }
    }

    /**
     * @param ScheduleUnit $unit
     * @param bool $priority
     * @return void
     */
    public function setHolidaySettings($unit, $priority = false)
    {
        foreach ($this->holiday_setting->holidays as $number_holiday => $holiday) {
            $holiday_start = new \DateTime();
            $holiday_end = new \DateTime();

            if ($priority) {
                $holiday_by_date = $this->getHolidayByDate($unit->getDate());
            }

            $pace_period = explode(' - ', $holiday['period']);
            $pace_date_start = explode('.', trim($pace_period[0]));
            $pace_date_end = explode('.', trim($pace_period[1]));
            $holiday_start->setDate($unit->getDate()->format('Y'), trim($pace_date_start[0]), trim($pace_date_start[1]));
            $holiday_end->setDate($unit->getDate()->format('Y'), trim($pace_date_end[0]), trim($pace_date_end[1]));
            if ($unit->getDate()->format('Y-m-d') >= $holiday_start->format('Y-m-d') && $unit->getDate()->format('Y-m-d') <= $holiday_end->format('Y-m-d')) {
                if (isset($holiday_by_date) && $holiday_by_date) {
                    $this->deleteHolidayByPeriod($holiday_by_date->date_start, $holiday_by_date->date_end, $holiday_by_date->name, $unit->getGroup());
                }

                $unit->setHoliday($this->createHoliday($holiday, $holiday_start, $holiday_end));
            }
        }
    }

    /**
     * @param ScheduleUnit $unit
     * @param bool $priority
     * @return void
     */
    public function setHolidayByDate($unit, $priority = false)
    {
        $holiday_by_date = $this->getHolidayByDate($unit->getDate());
        if ($priority) {
            foreach ($this->holiday_setting->holidays as $number_holiday => $holiday) {
                $holiday_start = new \DateTime();
                $holiday_end = new \DateTime();

                $pace_period = explode(' - ', $holiday['period']);
                $pace_date_start = explode('.', trim($pace_period[0]));
                $pace_date_end = explode('.', trim($pace_period[1]));
                $holiday_start->setDate($unit->getDate()->format('Y'), trim($pace_date_start[0]), trim($pace_date_start[1]));
                $holiday_end->setDate($unit->getDate()->format('Y'), trim($pace_date_end[0]), trim($pace_date_end[1]));
                if ($unit->getDate()->format('Y-m-d') >= $holiday_start->format('Y-m-d') && $unit->getDate()->format('Y-m-d') <= $holiday_end->format('Y-m-d')) {
                    $this->deleteHolidayByPeriod($holiday_start, $holiday_end, $holiday['name'], $unit->getGroup());
                }
            }
        }
        if ($holiday_by_date) {
            $unit->setHoliday($this->createHoliday($holiday_by_date->toArray(), $holiday_by_date->date_start, $holiday_by_date->date_end));
        }
    }

    /**
     * Удаляет выходные у группы по названию
     * @param $date_start
     * @param $date_end
     * @param $name
     * @param $group_id
     * @return void
     */
    private function deleteHolidayByPeriod($date_start, $date_end, $name, $group_id)
    {
        $units = $this->schedule->getScheduleUnitsByPeriod($date_start, $date_end, $group_id);

        foreach ($units as $unit) {
            if ($unit->getHoliday() && $unit->getHoliday()->getHolidayName() == $name) {
                $unit->setHoliday(null);
            }
        }
    }

}
