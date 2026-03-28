<?php
namespace App\Assets;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class SelectSearchBundle implements AssetBundleInterface {

    public function headerFiles(): array
    {
        return [
            'resources/plugins/css/select2-bootstrap4.min.css',
            'resources/plugins/css/select2.min.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js/jquery.min.js',
            'resources/plugins/js/select2.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
