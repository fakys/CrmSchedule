<?php

namespace App\Services\AssetsBundle\Domain\Entity;

use App\Services\AssetsBundle\Domain\ValueObjects\AssetFileValueObject;
use App\Services\AssetsBundle\Domain\ValueObjects\AssetTypeValueObject;

class AssetEntityFile
{
    private AssetFileValueObject $file;
    private AssetTypeValueObject $type;

    public function __construct(AssetFileValueObject $file, AssetTypeValueObject $type)
    {
        $this->file = $file;
        $this->type = $type;
    }

    public function getFile(): AssetFileValueObject
    {
        return $this->file;
    }

    public function getTypeFile(): AssetTypeValueObject
    {
        return $this->type;
    }
}
