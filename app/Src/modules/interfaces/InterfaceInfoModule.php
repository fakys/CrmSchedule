<?php
namespace App\Src\modules\interfaces;

interface InterfaceInfoModule{

    public static function getNameModule():string;

    public static function getRuNameModule():string;

    public static function getDescriptionModule():string;

    public static function repositories():array;

    public static function operations():array;
    public static function runConfig();
}
