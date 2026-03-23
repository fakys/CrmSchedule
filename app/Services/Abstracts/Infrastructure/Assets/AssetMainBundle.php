<?php
namespace App\Services\Abstracts\Infrastructure\Assets;


use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class AssetMainBundle implements AssetBundleInterface
{
    const CONTEXT = 'resources/';

    public function bodyFiles(): array
    {
        return [
            self::CONTEXT . 'js/plugins/jquery.min.js',
            self::CONTEXT . 'js/plugins/bootstrap.bundle.min.js',
            self::CONTEXT . 'js/plugins/adminlte.min.js',
        ];
    }

    public function headerFiles(): array
    {
        return [
            self::CONTEXT . 'css/plugins/all.min.css',
            self::CONTEXT . 'css/plugins/icheck-bootstrap.min.css',
            self::CONTEXT . 'css/plugins/adminlte.min.css',
            self::CONTEXT . 'css/plugins/fontawesome-free/css/all.min.css',
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
