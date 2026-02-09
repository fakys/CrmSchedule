<?php

namespace App\Modules\Crm\lessons\assets;

use App\Src\assets\AbstractAssets;

class EditInfoLessonsBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'app/Modules/Crm/lessons/resources/js/edit_lessons_info.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
        ];
    }
}
