<?php

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $user_color
 * @property integer $user_id
 */
class UserStyle extends Model
{
    protected $table = 'user_style';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_color',
        'user_id'
    ];
}
