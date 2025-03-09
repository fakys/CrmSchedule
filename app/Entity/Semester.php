<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $year_start
 * @property $year_end
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
        'year_start',
        'year_end',
        'date_start',
        'date_end',
    ];
}
