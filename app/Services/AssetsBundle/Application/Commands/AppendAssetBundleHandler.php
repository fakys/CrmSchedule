<?php

namespace App\Services\AssetsBundle\Application\Commands;

use App\Services\Abstracts\Application\Commands\AbstractHandler;
use App\Services\AssetsBundle\Application\DTO\AppendAssetBundleDto;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;

class AppendAssetBundleHandler extends AbstractHandler
{
    public function __construct(
        private AssetsBundleManagerInterface $assetBundleManager,
    ){}

    public function handle(AppendAssetBundleDto $handler)
    {
        foreach ($handler->getAssets() as $asset) {
            if (is_string($asset)) {
                $asset = new $asset();
            }
            $this->assetBundleManager->appendBundle($asset);
        }
    }
}
