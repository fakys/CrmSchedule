<?php
namespace App\Src\assets;

abstract class AbstractAssets {
    public static function JsFiles() : array
    {
        return [];
    }

    public static function CssFiles() : array
    {
        return [];
    }

    public function register()
    {

    }
}
