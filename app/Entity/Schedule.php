<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $duration_lesson_id
 * @property $pair_number_id
 * @property $description
 * @property $student_group_id
 * @property $updated_at
 * @property $format_lesson_id
 * @property $created_at
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
        'updated_at',
        'format_lesson_id'
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
        return $this->hasOne(Lesson::class, 'id', 'lessons_id')->first();
    }

    /**
     * @return PairNumber
     */
    public function getPairNumber()
    {
        return $this->hasOne(PairNumber::class, 'id', 'pair_number_id')->first();
    }
}
