<?php

namespace App\Modules\Crm\holidays\assets;

use App\Src\assets\AbstractAssets;

class HolidayIndexBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'resources/plugins/js/litepicker.js',
            'app/Modules/Crm/holidays/resources/js/holidays.js'
        ];
    }

    public static function CssFiles() : array
    {
        return [
            'resources/plugins/css/litepicker.css',
            'app/Modules/Crm/holidays/resources/css/holidays.css'
        ];
    }
}
