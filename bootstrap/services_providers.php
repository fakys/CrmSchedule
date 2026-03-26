<?php

use App\Services\AssetsBundle\Providers\AssetBundleProvider;
use App\Services\Forms\Providers\FromManagerProvider;
use App\Services\Table\Providers\TableProvider;
use App\Services\Validation\Providers\ValidationProvider;
use App\Services\Views\Providers\ViewProvider;

return [
    AssetBundleProvider::class,
    FromManagerProvider::class,
    ValidationProvider::class,
    ViewProvider::class,
    TableProvider::class,
];
