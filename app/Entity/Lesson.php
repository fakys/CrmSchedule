<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $subject_id
 * @property $format_lesson_id
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 */
class Lesson extends Model
{
    public $table = 'lessons';

    protected $fillable = [
        'subject_id',
        'format_lesson_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
