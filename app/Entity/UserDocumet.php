<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

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
