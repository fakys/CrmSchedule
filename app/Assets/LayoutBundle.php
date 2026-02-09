<?php

namespace App\Assets;

use App\Src\assets\AbstractAssets;

class LayoutBundle extends AbstractAssets
{
    public static function JsFiles() : array
    {
        return [
            'resources/plugins/js/jquery.min.js',
            'resources/js/base.js',
            'resources/plugins/js/bootstrap.min.js',
            'resources/layouts/js/adminlte.js'
        ];
    }

    public static function CssFiles() : array
    {
        return [
            'resources/layouts/css/adminlte.min.css',
            'resources/plugins/css/all.min.css',
            'resources/plugins/Html/css/styles.css',
            'resources/layouts/css/base_layout.css'
        ];
    }
}
