<?php

namespace App\Src\modules\interfaces;

use App\Src\modules\plugins\mangers\AbstractManger;

interface InterfaceInfoModule
{

    public static function getNameModule(): string;

    public static function getRuNameModule(): string;

    public static function getDescriptionModule(): string;

    public static function repositories(): array;

    public static function operations(): array;

    public static function runConfig();

    public static function tasks(): array;

    /**
     * @return AbstractManger[]
     */
    public static function mangers(): array;
    public static function components(): array;
    public static function crons(): array;
}
