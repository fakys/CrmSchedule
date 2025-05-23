<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Таблица базового расписания
 * @property $plan_duration_lesson_id
 * @property $lessons_id
 * @property $semester_id
 * @property $pair_number_id
 * @property $student_group_id
 * @property $description
 * @property $created_at
 * @property $updated_at
 * @property $plan_type_id
 */
class PlanSchedule extends Model
{
    public $table = 'plan_schedule';

    protected $fillable = [
        'plan_duration_lesson_id',
        'lessons_id',
        'pair_number_id',
        'student_group_id',
        'semester_id',
        'description',
        'created_at',
        'updated_at',
        'plan_type_id'
    ];


    /**
     * @return PlanDurationLesson|null
     */
    public function getDuration() {
        return $this->hasOne(PlanDurationLesson::class, 'id', 'plan_duration_lesson_id')->first();
    }

    /**
     * @return Lesson|null
     */
    public function getLesson() {
        return $this->hasOne(Lesson::class, 'id', 'lessons_id')->first();
    }

    /**
     * @return Semester|null
     */
    public function getSemestor() {
        return $this->hasOne(Semester::class, 'id', 'semester_id')->first();
    }
}
