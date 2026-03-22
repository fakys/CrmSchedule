<?php
namespace App\Src\assets;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

abstract class AbstractAssets implements AssetBundleInterface
{
    const MAIN_DIR = 'resources/';
}
