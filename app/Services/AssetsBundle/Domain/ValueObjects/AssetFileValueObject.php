<?php
namespace App\Services\AssetsBundle\Domain\ValueObjects;

use App\Services\AssetsBundle\Domain\Exceptions\UndefinedFileException;
use Illuminate\Support\Facades\File;

final class AssetFileValueObject
{
    protected $value;

    public function __construct(string $fileValueObject)
    {
        //Если файла нет не в паблик не в resources
        if (!File::exists(base_path($fileValueObject)) && !File::exists(public_path($fileValueObject))) {
            throw new UndefinedFileException($fileValueObject);
        }

        $this->value = $fileValueObject;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
