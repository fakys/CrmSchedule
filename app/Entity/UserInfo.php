<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $patronymic Отчество
 * @property string $email email
 * @property string $number_phone Номер телефона
 * @property string $photo фото
 * @property string $birthday дата рождения
 * @property integer $user_id
 */
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
