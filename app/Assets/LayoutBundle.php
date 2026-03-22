<?php

namespace App\Assets;

use App\Src\assets\AbstractAssets;

class LayoutBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            self::MAIN_DIR . 'layouts/css/adminlte.min.css',
            self::MAIN_DIR . 'plugins/css/all.min.css',
            self::MAIN_DIR . 'plugins/Html/css/styles.css',
            self::MAIN_DIR . 'layouts/css/base_layout.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            self::MAIN_DIR . 'plugins/js/jquery.min.js',
            self::MAIN_DIR . 'js/base.js',
            self::MAIN_DIR . 'plugins/js/bootstrap.min.js',
            self::MAIN_DIR . 'layouts/js/adminlte.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
