<?php

namespace App\Assets;

use App\Src\assets\AbstractAssets;

class BaseLayoutBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            self::MAIN_DIR . 'layouts/css/adminlte.min.css',
            self::MAIN_DIR . 'plugins/css/all.min.css',
        ];
    }

    public function bodyFiles(): array
    {
        return [
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
