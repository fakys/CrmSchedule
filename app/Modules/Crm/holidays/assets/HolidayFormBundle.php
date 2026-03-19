<?php

namespace App\Modules\Crm\holidays\assets;

use App\Src\assets\AbstractAssets;

class HolidayFormBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'resources/plugins/js/litepicker.js',
            'app/Modules/Crm/holidays/resources/js/holidays.js',
            'resources/plugins/js/select2.js',
            'resources/plugins/js/moment.min.js',
            'resources/plugins/js/daterangepicker.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
            'resources/plugins/css/litepicker.css',
            'app/Modules/Crm/holidays/resources/css/holidays.css',
            'resources/plugins/css/daterangepicker.css'
        ];
    }
}
