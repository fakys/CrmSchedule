<?php

namespace App\Services\AssetsBundle\Domain\Services\AssetsDriver;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use Illuminate\Support\HtmlString;

interface AssetDriverInterface
{
    public static function driverName(): string;
    public function buildFile(AssetEntityFile $entity): AssetEntityFile;
    public function registerFile(string $filePath, string $type): HtmlString;
    public function getPluginsType(): array;
}
