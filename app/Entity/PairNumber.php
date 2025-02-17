<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $number
 */
class PairNumber extends Model
{
    public $table = 'pair_numbers';
    protected $fillable = [
        'name',
        'number',
    ];
}
