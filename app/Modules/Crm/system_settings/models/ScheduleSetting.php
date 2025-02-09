<?php
namespace App\Modules\Crm\system_settings\models;

use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class ScheduleSetting extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'users_groups'
        ];
    }

    public function rules(): array
    {
        return [
            'users_groups'=>['required', 'array'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public static function getSettingName(): string
    {
        return 'schedule_settings';
    }
}
