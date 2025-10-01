<?php

namespace App\Src\modules\components;

use App\Src\modules\kernel\KernelModules;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractTagComponents extends AbstractComponents
{
    /**
     * Тег компонента
     * @return string
     */
    public function getTag()
    {
        return '';
    }
}
