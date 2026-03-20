<?php

namespace App\Src\modules;

use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\traits\TraitObjects;

class InfoModuleModel
{

    public static function repositories(): array
    {
        return [
        ];
    }

    public static function operations(): array
    {
        return [
        ];
    }
    public static function runConfig()
    {

    }

    public static function tasks(): array
    {
        return  [];
    }

    public static function mangers(): array
    {
        return [];
    }

    public static function components(): array
    {
        return [];
    }

    public static function crons(): array
    {
        return [];
    }

    public static function controllers(): array
    {
        return [];
    }

    public function requireModule(): bool
    {
        return false;
    }
}
