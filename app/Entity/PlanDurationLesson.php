<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $time_start
 * @property $time_end
 * @property $duration_minutes
 * @property $created_at
 * @property $updated_at
 */
class PlanDurationLesson extends Model {
    protected $table = 'plan_duration_lessons';

    protected $fillable = [
        'id',
        'time_start',
        'time_end',
        'duration_minutes',
        'created_at',
        'updated_at'
    ];
}
