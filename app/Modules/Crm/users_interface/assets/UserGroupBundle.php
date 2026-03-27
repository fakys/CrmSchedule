<?php

namespace App\Modules\Crm\users_interface\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;


class UserGroupBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            'app/Modules/Crm/users_interface/resources/css/user_groups_info.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'app/Modules/Crm/users_interface/resources/js/user_groups_info.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
