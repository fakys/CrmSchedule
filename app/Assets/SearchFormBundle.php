<?php

namespace App\Assets;

use App\Src\assets\AbstractAssets;

class SearchFormBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'resources/js/search_form.js',
        ];
    }

    public static function CssFiles() : array
    {
        return [
        ];
    }
}
