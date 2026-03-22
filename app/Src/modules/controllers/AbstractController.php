<?php

namespace App\Src\modules\controllers;

use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller
{

    public function __construct(
        private AssetsBundleManagerInterface $assetBundleManager,
    )
    {
        foreach ($this->assets() as $asset) {
            if (is_string($asset) && class_exists($asset)) {
                $asset = new $asset();
            }
            $this->assetBundleManager->appendBundle($asset);
        }
    }

    /**
     * @param KernelModules $kernel
     */
    abstract static function loadController(KernelModules $kernel);

    abstract static function assets(): array;
}
