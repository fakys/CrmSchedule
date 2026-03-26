<?php

namespace App\Assets;

use App\Src\assets\AbstractAssets;

class JsTableBundle extends AbstractAssets
{
    public function headerFiles(): array
    {
        return [
            self::MAIN_DIR . 'plugins/js_data/css/dataTables.bootstrap4.min.css',
        ];
    }

    public function bodyFiles(): array
    {
        return [
            self::MAIN_DIR . 'plugins/js_data/js/jquery.dataTables.min.js',
            self::MAIN_DIR . 'plugins/js_data/js/dataTables.bootstrap4.min.js',
            self::MAIN_DIR . 'plugins/js_data/js/responsive.bootstrap4.min.js',
            self::MAIN_DIR . 'plugins/js_data/js/dataTables.buttons.min.js',
            self::MAIN_DIR . 'plugins/js_data/js/js_table.js',
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
