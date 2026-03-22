<?php

namespace App\Modules\Crm\lessons\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;

class PairNumberBundle extends AbstractAssets
{
    public function headerFiles(): array
    {
        return [
            'app/Modules/Crm/lessons/resources/css/pair_info.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'app/Modules/Crm/lessons/resources/js/pair_number.js',
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class,
        ];
    }
}
