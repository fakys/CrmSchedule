<?php

namespace App\Modules\Crm\lessons\assets;

use App\Src\assets\AbstractAssets;

class EditInfoLessonsTabBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'resources/plugins/js/jquery.inputmask.min.js',
            'resources/js/tabs/edits/edit_tabs.js',
            'resources/plugins/js/moment.min.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
        ];
    }
}
