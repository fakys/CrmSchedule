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
     * @var \App\Entity\PairNumber[]
     */
    private $pair_numbers;

    public function __construct($date_start, $date_end, $base_schedule)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->base_schedule = $base_schedule;
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

    /**
     * Распределяет расписание
     * @param \DateTime $date
     * @param $schedule
     * @return void
     */
    public function distributesSchedule($date, $schedule = null)
    {
        $this->schedule[$date->format('d.m.Y')] = [];
        if ($this->pair_numbers) {
            foreach ($this->pair_numbers as $pair_number) {
                $this->schedule[$date->format('d.m.Y')][$pair_number->number] = [
                    'name_pair_number' => $pair_number->name,
                    'schedule' => null,
                ];
            }

            if ($schedule) {
                $this->schedule[$date->format('d.m.Y')][$schedule['pair_number']]['schedule'] = $schedule;
            }
        } else {
            throw new \Exception('Отсутствуют последовательность пар');
        }
    }


    private function createBadeScheduleDays()
    {
        dd(13123);
        /** хард-код надо будет поменять на настройку */
        $this->setSetting();
        switch ($this->type_weeks) {
            case ScheduleSetting::SIX_DAY:
                /** Прибавляем 1 т.к время с 00 до 23 и это не считается за день*/
                $count_days = $this->date_end->diff($this->date_start)->days + 1;
                $date_schedule = clone $this->date_start;
                if ($count_days) {
                    for ($day = 1; $day < $count_days; $day++) {
                        /** Флаг что на этот день расписание есть  */
                        $schedule_in_day = false;
                        foreach ($this->base_schedule as $base_schedule) {
                            $schedule_rep_date = new \DateTime($base_schedule['date_start']);
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
                    dd($this->schedule);
                }

                break;
            case ScheduleSetting::FIVE_DAY:
                break;
        }
    }
}
