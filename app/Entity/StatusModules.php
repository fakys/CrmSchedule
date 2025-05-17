<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $active
 * @property $create_user_id
 * @property $use_cash
 */
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
