<?php
namespace App\Modules\Crm\users_interface;

use App\Modules\Crm\users_interface\operations\UserAccessOperation;
use App\Modules\Crm\users_interface\operations\UsersGroupOperations;
use App\Modules\Crm\users_interface\operations\UsersOperation;
use App\Modules\Crm\users_interface\repositories\UserGroupsRepositories;
use App\Modules\Crm\users_interface\repositories\UsersRepositories;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use Illuminate\Support\Facades\Config;

class InfoModule extends InfoModuleModel implements  InterfaceInfoModule
{

    public static function getNameModule(): string
    {
        return 'users_interface';
    }

    public static function getRuNameModule(): string
    {
        return 'Модуль управления пользователями';
    }

    public static function getDescriptionModule(): string
    {
        return 'Модуль отвечающий за управления пользователями и их ролями';
    }

    public static function repositories(): array
    {
        return [
            UsersRepositories::class,
            UserGroupsRepositories::class
        ];
    }

    public static function operations(): array
    {
        return [
            UsersOperation::class,
            UserAccessOperation::class,
            UsersGroupOperations::class
        ];
    }

    public static function runConfig()
    {
        Config::set('view.paths', array(__DIR__.'/views'));
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
}
