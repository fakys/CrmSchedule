<?php

namespace App\Src\modules\kernel\entity;

use App\Src\modules\interfaces\InterfaceInfoModule;

class ModuleEntity {

    private $module;
    private $status;
    private $components;

    public function __construct($module, $status_module = false, $components = []) {
        $this->module = $module;
        $this->components = $components;
        $this->status = $status_module;
    }

    /**
     * @return InterfaceInfoModule
     */
    public function getModule() {
        return $this->module;
    }

    private function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return ComponentsEntity[]
     */
    public function getComponents() {
        return $this->components;
    }

    public function setComponents($components){
        $this->components = $components;
    }

    public function appendComponents($components)
    {
        $this->components[] = $components;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
