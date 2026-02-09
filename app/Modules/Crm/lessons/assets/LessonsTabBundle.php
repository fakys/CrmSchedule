<?php

namespace App\Modules\Crm\lessons\assets;

use App\Src\assets\AbstractAssets;

class LessonsTabBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'app/Modules/Crm/lessons/resources/js/edit_lessons_info.js',
            'resources/js/tabs/tabs.js'
        ];
    }

    public static function CssFiles() : array
    {
        return [
            'resources/css/tabs.css',
            'app/Modules/Crm/lessons/resources/css/pair_info.css'
        ];
    }
}
