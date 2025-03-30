<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $date_start
 * @property $date_end
 * @property $week_days
 * @property $format_id
 * @property $description
 * @property $created_at
 * @property $updated_at
 */
class Holiday extends Model
{
    public $table = 'holiday';

    protected $fillable = [
        'name',
        'date_start',
        'date_end',
        'week_days',
        'format_id',
        'description',
    ];
}
