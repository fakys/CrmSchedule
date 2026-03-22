<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\Exceptions\UndefinedTypePluginInViteDriverException;
use Illuminate\Support\HtmlString;

class ViteAssetDriver implements AssetDriverInterface
{
    public static function driverName(): string
    {
        return 'asset_vite';
    }

    public function __construct(
        private array $plugins
    ){}

    public function buildFile(AssetEntityFile $entity): AssetEntityFile
    {
        return $entity;
    }

    public function registerFile(string $filePath, string $type): HtmlString
    {
        $plugin = $this->plugins[$type]??null;
        if (!$plugin) {
            throw new UndefinedTypePluginInViteDriverException($type);
        }
        return $plugin->registerFile($filePath);
    }

    public function getPluginsType(): array
    {
        return array_keys($this->plugins);
    }
}
