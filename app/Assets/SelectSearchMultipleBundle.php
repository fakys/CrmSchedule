<?php
namespace App\Assets;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class SelectSearchMultipleBundle implements AssetBundleInterface {

    public function headerFiles(): array
    {
        return [
            'resources/plugins/css/select2-bootstrap4.min.css',
            'resources/plugins/css/bootstrap-duallistbox.min.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js/jquery.bootstrap-duallistbox.min.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
