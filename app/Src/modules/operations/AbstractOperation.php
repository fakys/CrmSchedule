<?php

namespace App\Src\modules\operations;

use App\Src\BackendHelper;
use App\Src\modules\components\AbstractComponents;
use App\Src\traits\TraitObjects;

abstract class AbstractOperation extends AbstractComponents
{
    use TraitObjects;

    public function getFullOperations(): OperationsContext
    {
        $modules = BackendHelper::getFullModule();
        $arr_operations = [];
        foreach ($modules as $module) {
            $arr_operations = array_merge($arr_operations, $module::operations());
        }
        return new OperationsContext($arr_operations);
    }

    abstract public function getName(): string;
}
