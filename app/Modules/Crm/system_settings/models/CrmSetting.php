<?php
namespace App\Modules\Crm\system_settings\models;

use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;

class CrmSetting extends Model implements InterfaceModel
{

    public function fields(): array
    {
        return [
            'site_tome_zone',
            'db_tome_zone',
            'system_name',
            'system_lang',
            'use_cash'
        ];
    }

    public function rules(): array
    {
        return [
            'site_tome_zone'=>['required','string'],
            'db_tome_zone'=>['required','string'],
            'system_name'=>['required','string'],
            'system_lang'=>['required','string'],
            'use_cash'=>['required','boolean'],
        ];
    }

    public function boolean(): array
    {
        return [
            'use_cash',
        ];
    }

    public static function getSettingName(): string
    {
        return 'crm_settings';
    }
}
