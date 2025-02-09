<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class PairNumber extends Model
{
    public $table = 'pair_numbers';
    protected $fillable = [
        'name',
        'number',
    ];
}
