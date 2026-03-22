<?php
namespace App\Services\AssetsBundle\Domain\ValueObjects;


final class AssetTypeValueObject
{
    private $value;

    public function __construct(string $type)
    {
        $this->value = $type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
