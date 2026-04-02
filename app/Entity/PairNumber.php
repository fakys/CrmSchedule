<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $number
 * @property $time_start
 * @property $time_end
 */
class PairNumber extends Model
{
    public $table = 'pair_numbers';

    protected $fillable = [
        'name',
        'number',
        'time_start',
        'time_end',
    ];
}
