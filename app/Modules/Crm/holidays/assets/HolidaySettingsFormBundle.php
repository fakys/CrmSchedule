<?php

namespace App\Modules\Crm\holidays\assets;

use App\Src\assets\AbstractAssets;

class HolidaySettingsFormBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'app/Modules/Crm/holidays/js/holidays_form.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
        ];
    }
}
