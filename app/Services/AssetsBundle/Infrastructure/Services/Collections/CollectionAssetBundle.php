<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\Collections;



use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

/**
 * Коллекция ассетов
 */
class CollectionAssetBundle
{
    private array $bundle = [];

    /**
     * @var AssetEntityFile[]
     */
    private array $body_entity = [];

    /**
     * @var \App\Services\AssetsBundle\Domain\Entity\AssetEntityFile[]
     */
    private array $header_entity = [];

    public function appendHeaderEntity(AssetEntityFile $path): void
    {
        $this->header_entity[$path->getFile()->getValue()] = $path;
    }

    public function appendBodyEntity(AssetEntityFile $path): void
    {
        $this->body_entity[$path->getFile()->getValue()] = $path;
    }


    public function checkLoadBundle(AssetBundleInterface $assetBundle): bool
    {
        return isset($this->bundle[$assetBundle::class]);
    }

    public function loadBundle(AssetBundleInterface $assetBundle): void
    {
        $this->bundle[$assetBundle::class] = $assetBundle::class;
    }

    public function getHeaderEntity(): array
    {
        return $this->header_entity;
    }

    public function getBodyEntity(): array
    {
        return $this->body_entity;
    }
}
