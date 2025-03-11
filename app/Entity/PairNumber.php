<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
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
