<?php

namespace App\Src\modules\components;

use App\Src\modules\kernel\KernelConstructor;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractComponents
{
    protected $kernel;

    /**
     * @param KernelConstructor $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    abstract public function getName(): string;
}
