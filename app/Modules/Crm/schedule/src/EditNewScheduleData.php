<?php

namespace App\Modules\Crm\schedule\src;


use App\Modules\Crm\schedule\src\entity\ScheduleUnit;

class EditNewScheduleData {
    private $new_schedule;

    private $shcedule_units = [];

    public function __construct($new_schedule)
    {
        /** Предполагается что данные будут уже откалиброванные в модели */
        $this->new_schedule = $new_schedule;
        $this->init();
    }

    public function init()
    {
        foreach ($this->new_schedule as $schedule_old_group => $schedule_group) {
            foreach ($schedule_group as $schedule_old_date=>$new_schedule_pairs) {
                foreach ($new_schedule_pairs as $pair_number => $schedule_new) {
                    $unit = new ScheduleUnit();
                    $unit->setOldDate($schedule_old_date);
                    $unit->setNewDate($schedule_new['schedule']['date_start']);
                    $unit->setOldGroup($schedule_old_group);
                    $unit->setNewGroup($schedule_new['schedule']['group_id']);
                    $unit->setOldPairNumber($pair_number);
                    $unit->setNewPairNumber($schedule_new['schedule']['pair_number']);
                    $unit->setTimeStart($schedule_new['schedule']['time_start']);
                    $unit->setTimeEnd($schedule_new['schedule']['time_end']);
                    $unit->setSubject($schedule_new['schedule']['subject_id']);
                    $unit->setUser($schedule_new['schedule']['user_id']);
                    $unit->setFormatPair($schedule_new['schedule']['format_lesson_id']);
                    $unit->setDescription($schedule_new['schedule']['schedule_description']);
                    $this->shcedule_units[] = $unit;
                }
            }
        }
    }

    /**
     * @return ScheduleUnit[]
     */
    public function getUnits()
    {
        return $this->shcedule_units;
    }
}
