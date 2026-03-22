<?php

namespace App\Services\AssetsBundle\Infrastructure\Exceptions;

class DriverTypePluginNotFoundException extends \Exception
{
    public function __construct(string $driverType)
    {
        parent::__construct("Тип $driverType не найден");
    }
}
