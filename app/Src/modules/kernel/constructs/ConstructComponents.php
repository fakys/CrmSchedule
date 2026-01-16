<?php

namespace App\Src\modules\kernel\constructs;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\components\AbstractTagComponents;
use App\Src\modules\exceptions\BackendException;
use App\Src\modules\interfaces\InterfaceInfoModule;
use App\Src\modules\kernel\entity\ComponentsEntity;
use App\Src\modules\kernel\KernelModules;
use App\Src\modules\operations\AbstractOperation;
use App\Src\modules\repository\AbstractRepositories;
use App\Src\traits\TraitObjects;
use Illuminate\Support\Collection;


/** Выполняет сборку компонентов для ядра */
class ConstructComponents
{
    use TraitObjects;

    const OPERATION_TYPE = 'operation';
    const REPOSITORY_TYPE = 'repository';
    const TASK_TYPE = 'task';
    const COMPONENTS_TYPE = 'components';
    const MANGER_TYPE = 'components';
    const CRON_TYPE = 'cron';

    /**
     * @var KernelModules
     */
    private $kernel;

    private $components;

    private $components_by_tag;

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
        /** @var Collection $modules */
        $modules = $this->kernel->getLaravelApp()->get(KernelModules::MODULE_KEY);
        foreach ($modules as $module) {
            if ($module->getStatus()) {
                foreach ($module->getModule()->operations() as $operation) {
                    $obj = new $operation($this->kernel);
                    if ($obj instanceof AbstractOperation) {
                        $module->appendComponents(new ComponentsEntity(self::OPERATION_TYPE, $obj->getName(), $obj));
                        $this->components[$obj->getName()] = $obj;
                        $this->setOperationByTag($obj);
                    }
                }

                foreach ($module->getModule()->repositories() as $repository) {
                    $obj = new $repository($this->kernel);
                    if ($obj instanceof AbstractRepositories) {
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

                foreach ($module->getModule()->mangers() as $mangers) {
                    $obj = new $mangers($this->kernel);
                    if ($obj instanceof AbstractComponents) {
                        $module->appendComponents(new ComponentsEntity(self::MANGER_TYPE, $obj->getName(), $obj));
                        $this->components[$obj->getName()] = $obj;
                    }
                }

                foreach ($module->getModule()->crons() as $crons) {
                    $obj = new $crons($this->kernel);
                    if ($obj instanceof AbstractComponents) {
                        $module->appendComponents(new ComponentsEntity(self::CRON_TYPE, $obj->getName(), $obj));
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
            }
        }
        return $this;
    }

    private function setOperationByTag($component)
    {
        if ($component->positionType() === AbstractOperation::PARENT_TYPE) {
            $this->components_by_tag[$component->getName()][$component->positionType()][] = $component;
            ksort($this->components_by_tag[$component->getName()][$component->positionType()]);
        }elseif (!$component->positionIndex()) {
            $this->components_by_tag[$component->getTag()][$component->positionType()][] = $component;
            ksort($this->components_by_tag[$component->getTag()][$component->positionType()]);
        } else {
            $this->components_by_tag[$component->getTag()][$component->positionType()][$component->positionIndex()] = $component;
            ksort($this->components_by_tag[$component->getTag()][$component->positionType()]);
        }
    }

    public function getComponentsForKernelByTag($tag)
    {
        if (isset($this->components_by_tag[$tag])) {
            return $this->components_by_tag[$tag];
        }
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
        return [];
    }

    public function getComponentsForKernelByType($type)
    {
        $data = [];
        foreach ($this->kernel->getModules() ?? [] as $module) {
            if ($module->getStatus()) {
                foreach ($module->getComponents() ?? [] as $component) {
                    if ($component->getType() === $type) {
                        $data[] = $component;
                    }
                }
            }
        }
        return $data;
    }
}
