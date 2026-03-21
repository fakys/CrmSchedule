<?php

namespace App\Src\modules\plugins\mangers;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\plugins\AbstractPlugin;

abstract class AbstractManger extends AbstractComponents
{

    public function __construct($kernel)
    {
        parent::__construct($kernel);
    }

    /**
     * @return AbstractPlugin[]
     */
    public function getPlugins()
    {
        return $this->kernel->getComponentsByTag($this->getName());
    }
}
