<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';
    protected $fillable = [
        'name',
        'settings',
        'active',
        'create_user_id',
        'use_cash'
    ];
}
