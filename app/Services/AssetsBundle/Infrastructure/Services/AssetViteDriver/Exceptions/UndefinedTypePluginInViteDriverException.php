<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\Exceptions;

class UndefinedTypePluginInViteDriverException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("[ViteDriver] Плагин с типом $type не найден!");
    }
}
