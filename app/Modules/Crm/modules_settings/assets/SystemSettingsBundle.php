<?php

namespace App\Modules\Crm\modules_settings\assets;

use App\Src\assets\AbstractAssets;

class SystemSettingsBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'app/Modules/Crm/modules_settings/resources/js/modules_settings.js'
        ];
    }

    public static function CssFiles() : array
    {
        return [
        ];
    }
}
