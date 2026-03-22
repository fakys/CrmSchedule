<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\RegisterPluginInterface;
use App\Services\AssetsBundle\Infrastructure\Exceptions\FileNotFoundException;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\Exceptions\UndefinedTypePluginInDefaultDriverException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;

class AssetDriver implements AssetDriverInterface
{
    const ASSETS_DIR = 'assets';
    const TEMPLATES_PATH = 'assets::default_driver';

    /**
     * @param RegisterPluginInterface[] $plugins
     */
    public function __construct(
        private array $plugins,
        private CreateAssetFileEntityFactory $factory,
    ){}

    public static function driverName(): string
    {
        return 'asset_default';
    }

    public function buildFile(AssetEntityFile $entity): AssetEntityFile
    {
        $filePath = ltrim($entity->getFile()->getValue(), '/');
        $fullFilePath = base_path($filePath);
        if (!File::exists($fullFilePath)) {
            throw new FileNotFoundException($fullFilePath);
        }

        $lastModified = File::lastModified($fullFilePath);

        $fileHash = md5($filePath.$lastModified);
        $extension = File::extension($fullFilePath);
        $newFileName =  pathinfo($filePath, PATHINFO_FILENAME).$fileHash.'.'.$extension;

        $pathNewFile = self::ASSETS_DIR.'/'.$entity->getTypeFile()->getValue().'/'.$newFileName;
        $fullPathNewFile = public_path($pathNewFile);
        if (!File::exists($fullPathNewFile)) {
            File::copy($fullFilePath, $fullPathNewFile);
        }
        return $this->factory->createAssetFileEntity($pathNewFile);
    }

    /**
     * Регистрируем плагин по типу
     * @param string $filePath
     * @param string $type
     * @return HtmlString
     * @throws \App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\Exceptions\UndefinedTypePluginInDefaultDriverException
     */
    public function registerFile(string $filePath, string $type): HtmlString
    {
        $plugin = $this->plugins[$type]??null;
        if (!$plugin) {
            throw new UndefinedTypePluginInDefaultDriverException($type);
        }
        return $plugin->registerFile($filePath);
    }

    public function getPluginsType(): array
    {
        return array_keys($this->plugins);
    }
}
