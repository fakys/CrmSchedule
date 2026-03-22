<?php
namespace App\Services\AssetsBundle\Domain\Services;

interface AssetBundleInterface
{
    public function headerFiles(): array;
    public function bodyFiles(): array;
    public function dependsBundle(): array;
}
