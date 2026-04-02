<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Таблица базового расписания
 * @property $id
 * @property $semester_id
 * @property $plan_type_id
 * @property $week_day
 * @property $week_number
 * @property $created_at
 * @property $updated_at
 * @property $schedule_id
 */
class PlanSchedule extends Model
{
    public $table = 'plan_schedule';

    protected $fillable = [
        'semester_id',
        'plan_type_id',
    ];

    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }
}
