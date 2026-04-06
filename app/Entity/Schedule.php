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
 * @property $lesson_id
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

    public function group()
    {
        return $this->hasOne(StudentGroup::class, 'id', 'student_group_id');
    }

    /**
     * @return Lesson|null
     */
    public function getLesson() {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id')->first();
    }

    public function lesson() {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id');
    }

    public function pairNumber()
    {
        return $this->hasOne(PairNumber::class, 'id', 'pair_number_id');
    }

    /**
     * @return PairNumber
     */
    public function getPairNumber()
    {
        return $this->hasOne(PairNumber::class, 'id', 'pair_number_id')->first();
    }
}
