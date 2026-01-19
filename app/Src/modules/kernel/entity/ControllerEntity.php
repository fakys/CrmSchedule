<?php

namespace App\Src\modules\kernel\entity;

use App\Src\modules\components\AbstractComponents;
use App\Src\modules\controllers\AbstractController;

class ControllerEntity {

    private $loadControllerData;

    public function __construct($loadControllerData)
    {
        $this->loadControllerData = $loadControllerData;
    }

    public function getLoadControllerData()
    {
        return $this->loadControllerData;
    }

}
