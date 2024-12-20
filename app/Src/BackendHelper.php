<?php

namespace App\Src;

use App\Modules\Crm\backend_module\interfaces\OperationsInterface;
use App\Modules\Crm\backend_module\interfaces\RepositoryInterface;
use App\Src\modules\InfoModuleModel;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\operations\Operation;
use App\Src\modules\operations\OperationsContext;
use App\Src\modules\repository\RepositoriesContext;
use App\Src\modules\repository\Repository;

class BackendHelper
{
    /**
     * @param string $module
     * @return InterfaceInfoModule
     */
    public static function getModule(string $module)
    {
        return InfoModuleModel::objects()->getInfoModuleByName($module);
    }

    public static function getFullModule()
    {
        return InfoModuleModel::objects()->getFullInfoModules();
    }

    /**
     * @return RepositoryInterface
     */
    public static function getRepositories(): RepositoriesContext
    {
        return Repository::objects()->getFullRepositories();
    }

    /**
     * @return OperationsInterface
     */
    public static function getOperations(): OperationsContext
    {
        return Operation::objects()->getFullOperations();
    }
}
