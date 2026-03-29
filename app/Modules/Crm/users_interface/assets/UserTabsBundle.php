<?php

namespace App\Modules\Crm\users_interface\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;


class UserTabsBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'resources/tabs/tabs.css',
            'app/Modules/Crm/users_interface/resources/css/tabs/users_info.css'
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
