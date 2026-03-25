<?php

namespace App\Modules\Crm\users_interface\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;


class AddUserBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
        ];
    }

    public function bodyFiles(): array
    {
        return [
            self::MAIN_DIR.'js/add_user.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
        ];
    }
}
