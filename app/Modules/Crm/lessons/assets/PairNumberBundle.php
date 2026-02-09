<?php

namespace App\Modules\Crm\lessons\assets;

use App\Src\assets\AbstractAssets;

class PairNumberBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'app/Modules/Crm/lessons/resources/js/pair_number.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
            'app/Modules/Crm/lessons/resources/css/pair_info.css'
        ];
    }
}
