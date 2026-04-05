<?php

namespace App\Modules\Crm\schedule\Entity;

use App\Entity\Lesson;
use App\Entity\Schedule;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $schedule_id
 * @property $lesson_id
 */
class ScheduleToLessons extends Model
{
    protected $table = 'schedule_to_lessons';

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id');
    }
}
