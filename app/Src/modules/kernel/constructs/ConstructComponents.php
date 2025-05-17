<?php

namespace App\Src\modules\kernel\constructs;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\entity\ComponentsEntity;
use App\Src\modules\kernel\KernelModules;
use App\Src\modules\operations\AbstractOperation;
use App\Src\traits\TraitObjects;


/** Выполняет сборку компонентов для ядра */
class ConstructComponents
{
    use TraitObjects;

    const OPERATION_TYPE = 'operation';
    const REPOSITORY_TYPE = 'repository';
    const TASK_TYPE = 'task';
    const COMPONENTS_TYPE = 'components';
    const MANGER_TYPE = 'components';

    /**
     * @var KernelModules
     */
    private $kernel;

    private $components;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }
    /**
     * @return constructComponents
     */
    public static function constructComponents($kernel)
    {
        return self::objects($kernel)->collectComponentsByModulesForKernel();
    }

    public function collectComponentsByModulesForKernel()
    {
        foreach ($this->kernel->getModules()??[] as $module) {

            foreach ($module->getModule()->operations() as $operation) {
                $obj = new $operation($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::OPERATION_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
            foreach ($module->getModule()->repositories() as $repository) {
                $obj = new $repository($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::REPOSITORY_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
            foreach ($module->getModule()->tasks() as $task) {
                $obj = new $task($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::TASK_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
            foreach ($module->getModule()->components() as $component) {
                $obj = new $component($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::COMPONENTS_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
            foreach ($module->getModule()->mangers() as $mangers) {
                $obj = new $mangers($this->kernel);
                if ($obj instanceof AbstractComponents) {
                    $module->appendComponents(new ComponentsEntity(self::MANGER_TYPE, $obj->getName(), $obj));
                    $this->components[$obj->getName()] = $obj;
                }
            }
        }
        return $this;
    }

    public function getComponentsForKernelByName($name)
    {
        foreach ($this->kernel->getModules() ?? [] as $module) {
            foreach ($module->getComponents() ?? [] as $component) {
                if ($component->getName() === $name) {
                    return $component;
                }
            }
        }
        throw new BackendException("Компонент $name не найден");
    }
}
