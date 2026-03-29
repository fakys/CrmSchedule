<?php

namespace App\Modules\Crm\lessons\assets;

use App\Src\assets\AbstractAssets;


class LessonTabsBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'resources/tabs/tabs.css',
            'app/Modules/Crm/users_interface/resources/css/tabs/lessons.css'
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
