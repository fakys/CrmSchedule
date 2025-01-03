<?php
namespace App\Modules\Crm\system_settings\models;

use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class SystemSetting extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'system_users',
            'system_user_groups',
        ];
    }

    public function rules(): array
    {
        return [
            'system_users'=>['array'],
            'system_user_groups'=>['array'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public static function getSettingName(): string
    {
        return 'system_settings';
    }
}
