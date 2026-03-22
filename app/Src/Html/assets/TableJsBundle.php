<?php
namespace App\Src\Html\assets;

use App\Assets\LayoutBundle;
use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class TableJsBundle implements AssetBundleInterface {

    public function headerFiles(): array
    {
        return [
            'resources/plugins/js_data/css/dataTables.bootstrap4.min.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js_data/js/jquery.dataTables.min.js',
            'resources/plugins/js_data/js/dataTables.bootstrap4.min.js',
            'resources/plugins/js_data/js/responsive.bootstrap4.min.js',
            'resources/plugins/js_data/js/dataTables.buttons.min.js',
            'resources/plugins/js_data/js/js_table.js',
        ];
    }

    public function dependsBundle(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
