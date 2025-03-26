<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $settings
 * @property bool $active
 * @property int $create_user_id
 */
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
