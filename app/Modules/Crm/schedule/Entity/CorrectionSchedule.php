<?php

namespace App\Modules\Crm\schedule\Entity;

use App\Entity\Lesson;
use App\Entity\Schedule;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $date_start
 * @property $schedule_id
 * @property $schedule_plan_id
 */
class CorrectionSchedule extends Model
{
    protected $table = 'correction_schedule';

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }
}
