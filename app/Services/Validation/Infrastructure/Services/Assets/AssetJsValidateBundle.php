<?php
namespace App\Services\Validation\Infrastructure\Services\Assets;


use App\Services\Abstracts\Infrastructure\Assets\AssetMainBundle;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class AssetJsValidateBundle implements AssetBundleInterface
{
    const CONTEXT = 'resources/';

    public function dependsBundle(): array
    {
        return [];
    }

    public function bodyFiles(): array
    {
        return [
            self::CONTEXT . 'plugins/js/jquery.min.js',
            self::CONTEXT . 'js/validation/jquery.validate.min.js',
            self::CONTEXT . 'js/validation/validator.js',
        ];
    }

    public function headerFiles(): array
    {
        return [];
    }
}
