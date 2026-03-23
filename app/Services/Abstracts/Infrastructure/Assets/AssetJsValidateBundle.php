<?php
namespace App\Services\Abstracts\Infrastructure\Assets;


use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class AssetJsValidateBundle implements AssetBundleInterface
{
    const CONTEXT = 'resources/';

    public function dependsBundle(): array
    {
        return [
            AssetMainBundle::class,
        ];
    }

    public function bodyFiles(): array
    {
        return [
            self::CONTEXT . 'js/validation/jquery.validate.min.js',
            self::CONTEXT . 'js/validation/validator.js',
        ];
    }

    public function headerFiles(): array
    {
        return [];
    }
}
