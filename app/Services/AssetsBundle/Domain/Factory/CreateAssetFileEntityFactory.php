<?php
namespace App\Services\AssetsBundle\Domain\Factory;

use App\Services\AssetsBundle\Domain\Entity\AssetEntityFile;
use App\Services\AssetsBundle\Domain\ValueObjects\AssetFileValueObject;
use App\Services\AssetsBundle\Domain\ValueObjects\AssetTypeValueObject;
use Illuminate\Filesystem\Filesystem;

/** Фобрика создающая сущность файла стилей */
class CreateAssetFileEntityFactory
{
    public function __construct(
        private Filesystem $file,
    ){}

    public function createAssetFileEntity($path): AssetEntityFile
    {
        $type = strtolower($this->file->extension($path));
        return new AssetEntityFile(
            new AssetFileValueObject($path),
            new AssetTypeValueObject($type)
        );
    }
}
