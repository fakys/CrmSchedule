<?php

namespace App\Services\AssetsBundle\Infrastructure\Services;

use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetBundleBuilder;
use App\Services\AssetsBundle\Infrastructure\Services\AssetBundleRegister;
use Illuminate\Support\HtmlString;

/**
 * Менеджер асетов
 */
class AssetBundleManager implements \App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface
{
    public function __construct(
        private AssetBundleBuilder $assetBundle,
        private AssetBundleRegister $assetRegister,
        private CreateAssetFileEntityFactory $factory
    ){}

    public function appendBundle(AssetBundleInterface $bundle)
    {
        $this->assetBundle->buildAssetBundle($bundle);
    }

    public function registerBodyFiles(): HtmlString
    {
        return $this->assetRegister->registerBodyFiles();
    }

    public function registerHeaderFiles(): HtmlString
    {
        return $this->assetRegister->registerHeaderFiles();
    }

    public function registerFile(string $filePath): HtmlString
    {
        $element = $this->factory->createAssetFileEntity($filePath);
        $this->assetBundle->buildFile($element);

        return $this->assetRegister->renderAssetFileEntity($element);
    }
}
