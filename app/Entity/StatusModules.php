<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class StatusModules extends Model
{
    protected $table = 'status_modules';
    protected $fillable = [
        'name',
        'active',
        'create_user_id',
        'use_cash'
    ];
}
