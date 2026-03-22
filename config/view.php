<?php

use App\Services\AssetsBundle\Providers\AssetDefaultDriverProvider;

return [
    'assets' => [
        'asset_driver_provider' => AssetDefaultDriverProvider::class,
    ]
];
