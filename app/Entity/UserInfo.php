<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $table = 'users_info';
    protected $fillable = [
        'last_name',
        'first_name',
        'patronymic',
        'email',
        'number_phone',
        'birthday'
    ];
}
