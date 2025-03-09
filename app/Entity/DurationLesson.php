<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $date_start
 * @property $time_start
 * @property $time_end
 * @property $duration_minutes
 * @property $created_at
 * @property $updated_at
 */
class DurationLesson extends Model {
    protected $table = 'duration_lessons';

    protected $fillable = [
        'id',
        'date_start',
        'time_start',
        'time_end',
        'duration_minutes',
        'created_at',
        'updated_at'
    ];
}
