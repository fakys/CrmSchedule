<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $specialty_id
 */
class StudentGroup extends Model{

    protected $table = 'student_groups';

    protected $fillable = [
        'number',
        'name',
        'specialty_id',
    ];
}
