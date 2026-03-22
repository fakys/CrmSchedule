<?php

namespace App\Services\AssetsBundle\Application\DTO;

use App\Services\Abstracts\DTO\AbstractDto;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class AppendAssetBundleDto extends AbstractDto
{
    private array $assets;

    /**
     * @param AssetBundleInterface[] $assets
     */
    public function __construct(array $assets)
    {
        $this->assets = $assets;
    }

    /**
     * @return AssetBundleInterface[]
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    /**
     * @param \App\Services\AssetsBundle\Domain\Services\AssetBundleInterface[] $assets
     * @return void
     */
    public function setAssets(array $assets)
    {
        $this->assets = $assets;
    }

    public function appendAsset(AssetBundleInterface $assets)
    {
        $this->assets[] = $assets;
    }
}
