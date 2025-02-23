<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $duration_lesson_id
 * @property $lessons_id
 * @property $pair_number_id
 * @property $student_group_id
 * @property $description
 * @property $created_at
 * @property $updated_at
 */
class Schedule extends Model
{
    public $table = 'schedules';

    protected $fillable = [
        'duration_lesson_id',
        'lessons_id',
        'pair_number_id',
        'student_group_id',
        'description',
        'created_at',
        'updated_at'
    ];


    /**
     * @return DurationLesson|null
     */
    public function getDuration() {
        return $this->hasOne(DurationLesson::class, 'id', 'duration_lesson_id')->first();
    }

    /**
     * @return Lesson|null
     */
    public function getLesson() {
        return $this->hasOne(Lesson::class, 'id', 'duration_lesson_id')->first();
    }
}
