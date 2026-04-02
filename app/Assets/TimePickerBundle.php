<?php
namespace App\Assets;

use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;

class TimePickerBundle implements AssetBundleInterface {

    public function headerFiles(): array
    {
        return [
            'resources/plugins/css/timepicker.css'
        ];
    }

    public function bodyFiles(): array
    {
        return [
            'resources/plugins/js/time-picker/jquery-clockpicker.min.js',
            'resources/plugins/js/time-picker/highlight.min.js',
            'resources/plugins/js/time-picker/clockpicker.js'
        ];
    }

    public function dependsBundle(): array
    {
        return [];
    }
}
