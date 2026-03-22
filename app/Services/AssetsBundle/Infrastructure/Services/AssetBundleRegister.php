<?php

namespace App\Services\AssetsBundle\Infrastructure\Services;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Services\Collections\CollectionAssetBundle;
use Illuminate\Support\HtmlString;

/**
 * Менеджер регистрации в странице ассетов
 */
class AssetBundleRegister
{

    public function __construct(
        private CollectionAssetBundle $collection,
        private AssetDriverInterface $driver
    ){}

    /**
     * Регистрация файлов теле
     */
    public function registerBodyFiles(): \Illuminate\Support\HtmlString
    {
        $htmlString = '';
        foreach ($this->collection->getBodyEntity() as $asset) {
            $htmlString .= $this->renderAssetFileEntity($asset);
        }
        return new HtmlString($htmlString);
    }

    /**
     * Регистрация файлов в шапке
     */
    public function registerHeaderFiles(): \Illuminate\Support\HtmlString
    {
        $htmlString = '';
        foreach ($this->collection->getHeaderEntity() as $asset) {
            $htmlString .= $this->renderAssetFileEntity($asset);
        }
        return new HtmlString($htmlString);
    }

    public function renderAssetFileEntity(AssetEntityFile $entity)
    {
        return $this->driver->registerFile($entity->getFile()->getValue(), $entity->getTypeFile()->getValue());
    }
}
