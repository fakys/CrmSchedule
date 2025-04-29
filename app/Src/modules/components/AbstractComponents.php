<?php

namespace App\Src\modules\components;

use App\Src\modules\kernel\KernelModules;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractComponents
{
    private $kernel;

    /**
     * @param KernelModules $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    abstract public function getName(): string;
}
