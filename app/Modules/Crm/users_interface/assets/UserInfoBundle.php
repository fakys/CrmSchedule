<?php

namespace App\Modules\Crm\users_interface\assets;

use App\Assets\LayoutBundle;
use App\Src\assets\AbstractAssets;


class UserInfoBundle extends AbstractAssets
{

    public function headerFiles(): array
    {
        return [
            self::MAIN_DIR.'plugins/css/select2.min.css',
            self::MAIN_DIR.'plugins/css/select2-bootstrap4.min.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            self::MAIN_DIR.'plugins/js/select2.js',
            'app/Modules/Crm/users_interface/resources/js/search_form.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
