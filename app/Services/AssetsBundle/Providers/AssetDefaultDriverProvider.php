<?php

namespace App\Services\AssetsBundle\Providers;

use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\AssetDriver;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\RegisterPlugins\DefaultRegisterCssPlugin;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\RegisterPlugins\DefaultRegisterJsPlugin;
use App\Services\AssetsBundle\Providers\AssetBundleProvider;
use Illuminate\Support\ServiceProvider;

class AssetDefaultDriverProvider extends ServiceProvider implements ProviderInterface
{
    public function register(): void
    {
        $this->app->singleton(
            AssetDriverInterface::class,
            function ($app) {
                $plugins = [
                    DefaultRegisterCssPlugin::pluginType() => new DefaultRegisterCssPlugin(),
                    DefaultRegisterJsPlugin::pluginType() => new DefaultRegisterJsPlugin(),
                ];
                $factory = $app->get(CreateAssetFileEntityFactory::class);

                $driver = new AssetDriver($plugins, $factory);
                return $driver;
            }
        );
    }

    public function boot()
    {

    }

    public static function serviceName(): string
    {
        return 'AssetDefaultDriver';
    }

    public static function dependsServices(): array
    {
        return [
            AssetBundleProvider::serviceName()
        ];
    }
}
