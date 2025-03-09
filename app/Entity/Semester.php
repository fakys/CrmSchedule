<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $date_start
 * @property $date_end
 * @property $updated_at
 * @property $created_at
 */
class Semester extends Model
{
    public $table = 'semesters';

    protected $fillable = [
        'name',
        'date_start',
        'date_end',
    ];
}
