<?php
namespace App\Assets;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class PeriodDatePickerBundle implements AssetBundleInterface {

    public function headerFiles(): array
    {
        return [
            'resources/plugins/css/daterangepicker.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js/moment.min.js',
            'resources/plugins/js/jquery.inputmask.min.js',
            'resources/plugins/js/daterangepicker.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
