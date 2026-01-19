<?php

namespace App\Src;

use App\Modules\Crm\backend_module\interfaces\OperationsInterface;
use App\Modules\Crm\backend_module\interfaces\RepositoryInterface;
use App\Src\access\ContextAccessRoute;
use App\Src\crons\TaskSchedule;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\kernel\entity\ModuleEntity;
use App\Src\modules\ModulesHelper;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\KernelConstructor;
use App\Src\modules\operations\OperationsContext;
use App\Src\modules\repository\RepositoriesContext;
use App\Src\modules\settings\Settings;
use App\Src\modules\task\AbstractTask;
use Illuminate\Support\Collection;

class BackendHelper
{

    /**
     * @return RepositoryInterface
     */
    public static function getRepositories()
    {
        return RepositoriesContext::objects();
    }

    /**
     * @return OperationsInterface
     */
    public static function getOperations(): OperationsContext
    {
        return OperationsContext::objects();
    }

    /**
     * Получает access по uri
     * @param string $uri
     * @return access\models\AccessModel|false
     */
    public static function getAccess(string $uri)
    {
        return ContextAccessRoute::getByUriAccess($uri);
    }

    /**
     * Проверяет есть ли у пользователя роль
     * @param $access
     * @param $user_id
     * @return bool
     */
    public static function checkAccess($access, $user_id)
    {
        return ContextAccessRoute::objects()->checkUserByAccess($access, $user_id);
    }

    /**
     * Проверяет есть ли у пользователя роль по имени роута
     * @param $name
     * @return bool
     */
    public static function checkAccessByNameRoute($name)
    {
        return ContextAccessRoute::objects()->checkAccessByNameRoute($name);
    }

    /**
     * Получает настройки по названию
     * @param $name
     * @return Settings
     */
    public static function getSystemSettings($name)
    {
        $settings = new Settings(BackendHelper::getOperations()->getCurrentSystemSettings($name));
        return $settings;
    }

    public static function taskCreate($task_name, $args = [])
    {
        return TaskSchedule::objects()->taskCreate($task_name, $args);
    }

    /**
     * @return KernelConstructor
     */
    public static function getKernel()
    {
        return KernelConstructor::getKernelModule();
    }

    /**
     * Проверяет статус модуля
     * @param $name
     * @return bool
     * @throws modules\exceptions\BackendException
     */
    public static function checkModule($name)
    {
        return self::getModuleByName($name)->getStatus();
    }

    /**
     * @param $nameModule
     * @return ModuleEntity
     * @throws BackendException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function getModuleByName($nameModule)
    {
        try {
            /** @var Collection $modules */
            $modules = app()->get(KernelConstructor::MODULE_KEY);
            return $modules[$nameModule];
        } catch (\Exception $e) {
            throw new BackendException("Модуль по названию $nameModule ненайден");
        }
    }
}
