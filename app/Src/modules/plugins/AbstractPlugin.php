<?php

namespace App\Src\modules\plugins;

use App\Src\modules\components\AbstractTagComponents;
use App\Src\modules\plugins\mangers\PluginsMangerContext;

abstract class AbstractPlugin extends AbstractTagComponents
{
    public function __construct($kernel)
    {
        parent::__construct($kernel);
    }
}
