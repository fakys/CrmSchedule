<?php
namespace App\Modules\Crm\schedule\src\entity;


use App\Modules\Crm\system_settings\models\ScheduleSetting;
use App\Src\BackendHelper;
use function Symfony\Component\String\b;

class ScheduleDays
{

    private $shcdule_days;

    private $date_end;
    private $date_start;
    private $type_weeks;
    /**
     * @var array $base_schedule расписание из репозитория getScheduleByGroupFroManager
     */
    private $base_schedule;

    private $schedule;

    /**
     * @var \App\Entity\Schedule[]
     */
    private $pair_numbers;
    private $group_id;
    private $group_name;

    public function __construct($date_start, $date_end, $base_schedule, $group_id = null)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->base_schedule = $base_schedule;
        $this->group_id = $group_id;
        $this->pair_numbers = BackendHelper::getRepositories()->getNumberPair();
    }

    private function setSetting()
    {
        $settings = BackendHelper::getSystemSettings(ScheduleSetting::getSettingName());

        /**
         * По умолчанию берем шестидневку
         */
        if (!$settings->type_weeks) {
            $this->type_weeks = ScheduleSetting::SIX_DAY;
        } else {
            $this->type_weeks = $settings->type_weeks;
        }
    }

    private function getGroupName()
    {
        if (!$this->group_name){
            $group_name = BackendHelper::getRepositories()->getStudentGroupById($this->group_id)->number;
            $this->group_name = $group_name;
        }
        return $this->group_name;
    }

    /**
     * Распределяет расписание
     * @param \DateTime $date
     * @param $schedule
     * @return void
     */
    private function distributesSchedule($date, $schedule = null)
    {
        $group_name = $this->getGroupName();
        if (empty($this->schedule[$group_name])) {
            $this->schedule[$group_name] = [];
        }
        $this->schedule[$group_name][$date->format('d.m.Y')] = [];
        if ($this->pair_numbers) {
            foreach ($this->pair_numbers as $pair_number) {
                $this->schedule[$group_name][$date->format('d.m.Y')][$pair_number->number] = [
                    'name_pair_number' => $pair_number->name,
                    'student_group' => $this->group_id,
                    'schedule' => null,
                ];
            }
            if ($schedule) {
                $this->schedule[$group_name][$date->format('d.m.Y')][$schedule->pair_number]['schedule'] = $schedule;
            }
        } else {
            throw new \Exception('Отсутствуют последовательность пар');
        }
    }


    public function createBadeScheduleDays()
    {
        if ($this->schedule) {
            return $this->schedule;
        }

        /** хард-код надо будет поменять на настройку */
        $this->setSetting();

        /** Прибавляем 1 т.к время с 00 до 23 и это не считается за день*/
        $count_days = $this->date_end->diff($this->date_start)->days + 1;
        $date_schedule = clone $this->date_start;
        if ($count_days) {
            for ($day = 1; $day <= $count_days; $day++) {
                /** Пропускаем выходные дни */
                if ($this->type_weeks == ScheduleSetting::SIX_DAY && $date_schedule->format('w') == 1) {
                    $date_schedule->modify("+1 day");
                    continue;
                } elseif (
                    $this->type_weeks == ScheduleSetting::FIVE_DAY &&
                    (
                        $date_schedule->format('w') == 6 ||
                        $date_schedule->format('w') == 0
                    )
                ) {
                    $date_schedule->modify("+1 day");
                    continue;
                }

                /** Флаг что на этот день расписание есть  */
                $schedule_in_day = false;
                foreach ($this->base_schedule as $base_schedule) {
                    $schedule_rep_date = new \DateTime($base_schedule->date_start);
                    /** Если есть расписание на этот день */
                    if ($date_schedule->format('Y-m-d') == $schedule_rep_date->format('Y-m-d')) {
                        $schedule_in_day = true;
                        $this->distributesSchedule($date_schedule, $base_schedule);
                    }
                }
                /** если на этот день расписания нет то строим пустое расписание */
                if (!$schedule_in_day) {
                    $this->distributesSchedule($date_schedule);
                }
                $date_schedule->modify("+1 day");
            }
        }

        return $this->schedule;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }
}
