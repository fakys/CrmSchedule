<?php

namespace App\Src;

use App\Modules\Crm\backend_module\interfaces\OperationsInterface;
use App\Modules\Crm\backend_module\interfaces\RepositoryInterface;
use App\Src\access\ContextAccessRoute;
use App\Src\crons\TaskSchedule;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\KernelModules;
use App\Src\modules\operations\OperationsContext;
use App\Src\modules\repository\RepositoriesContext;
use App\Src\modules\settings\Settings;
use App\Src\modules\task\AbstractTask;

class BackendHelper
{
    /**
     * @return InterfaceInfoModule[]
     */
    public static function getFullModule()
    {
        return InfoModuleModel::objects()->getFullInfoModules();
    }

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
     * Возвращает менеджер по имени
     * @param $name
     * @return modules\plugins\mangers\AbstractManger
     * @throws modules\exceptions\BackendException
     */
    public static function getManager($name)
    {
        return self::getKernel()->getComponentByName($name)->getComponent();
    }

    /**
     * @return KernelModules
     */
    public static function getKernel()
    {
        return KernelModules::getKernelModule();
    }

    /**
     * @param $name
     * @return AbstractTask
     */
    public static function getTaskByName($name)
    {
        return self::getKernel()->getComponentByName($name)->getComponent();
    }

    /**
     * Проверяет статус модуля
     * @param $name
     * @return false|mixed
     * @throws modules\exceptions\BackendException
     */
    public function checkModule($name)
    {
        return self::getKernel()->getModulByName($name)->getStatus();
    }
}
