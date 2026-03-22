<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\Exceptions;

class UndefinedTypePluginInDefaultDriverException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("[DefaultDriver] Плагин с типом $type не найден!");
    }
}
