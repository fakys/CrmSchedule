<?php

namespace App\Src\modules\kernel\entity;

use App\Src\modules\components\AbstractComponents;

class ComponentsEntity {
    private $type;
    private $name;
    private $component;

    /**
     * @param string $type
     * @param string $name
     * @param AbstractComponents $component
     */
    public function __construct(string $type, string $name, $component)
    {
        $this->type = $type;
        $this->name = $name;
        $this->component = $component;
    }

    public function getType() {
        return $this->type;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @return AbstractComponents
     */
    public function getComponent() {
        return $this->component;
    }
}
