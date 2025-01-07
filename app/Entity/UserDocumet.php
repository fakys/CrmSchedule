<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $inn ИНН
 * @property string $passport_series Серия паспорта
 * @property string $passport_number Номер паспорта
 * @property string $snils СНИЛС
 * @property string $address Адрес
 * @property integer $user_id
 */
class UserDocumet extends Model
{
    protected $table = 'users_documents';
    protected $fillable = [
        'inn',
        'passport_series',
        'passport_number',
        'snils',
        'address'
    ];
}
