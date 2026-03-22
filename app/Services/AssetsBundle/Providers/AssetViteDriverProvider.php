<?php

namespace App\Services\AssetsBundle\Providers;

use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\RegisterPlugins\ViteRegisterCssPlugin;
use App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\RegisterPlugins\ViteRegisterJsPlugin;
use App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\ViteAssetDriver;
use App\Services\AssetsBundle\Providers\AssetBundleProvider;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class AssetViteDriverProvider extends ServiceProvider implements ProviderInterface
{
    public function register(): void
    {
        $this->app->bind(
            AssetDriverInterface::class,
            function ($app) {
                $vite = $app->make(Vite::class);
                $plugins = [
                    ViteRegisterCssPlugin::pluginType() => new ViteRegisterCssPlugin($vite),
                    ViteRegisterJsPlugin::pluginType() => new ViteRegisterJsPlugin($vite),
                ];

                $driver = new ViteAssetDriver($plugins);
                return $driver;
            }
        );
    }

    public function boot()
    {

    }

    public static function serviceName(): string
    {
        return 'AssetViteDriver';
    }

    public static function dependsServices(): array
    {
        return [
            AssetBundleProvider::serviceName()
        ];
    }
}
