<?php

namespace App\Services\AssetsBundle\Domain\Facades;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HtmlString;

/**
 * @method static appendBundle(AssetBundleInterface $bundle)
 * @method static HtmlString registerBodyFiles()
 * @method static HtmlString registerHeaderFiles()
 *
 */
class AssetBundleManager extends Facade
{

    protected static function getFacadeAccessor()
    {
        return AssetsBundleManagerInterface::class;
    }
}
