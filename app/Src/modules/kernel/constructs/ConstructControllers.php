<?php

namespace App\Src\modules\kernel\constructs;

use App\Src\modules\controllers\ControllerLoader;
use App\Src\modules\kernel\KernelModules;
use App\Src\traits\TraitObjects;


class ConstructControllers
{
    use TraitObjects;

    /**
     * @var KernelModules
     */
    private $kernel;

    private $controllers;

    private $controllers_loader;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
        $this->controllers_loader = new ControllerLoader();
    }
    /**
     * @return constructComponents
     */
    public static function constructObject($kernel)
    {
        return self::objects($kernel);
    }

    public function collectControllerByModulesForKernel()
    {
        foreach ($this->kernel->getLaravelApp()->get(KernelModules::MODULE_KEY) as $module) {
            foreach ($module->getModule()->controllers() as $controller) {
                $this->controllers[] = $controller;
                $controller::loadController($this->kernel);
            }
        }
    }

    public function getControllerLoaderForKernel()
    {
        return $this->controllers_loader;
    }
}
