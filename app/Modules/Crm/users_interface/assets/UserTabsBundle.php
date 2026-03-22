<?php

namespace App\Modules\Crm\users_interface\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;


class UserTabsBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'app/Modules/Crm/users_interface/resources/css/tabs.css',
            'app/Modules/Crm/users_interface/resources/css/users_info.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'app/Modules/Crm/users_interface/resources/js/tabs.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
