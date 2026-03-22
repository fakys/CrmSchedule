<?php

namespace App\Services\AssetsBundle\Providers;

use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\AssetsBundle\Application\Commands\AppendAssetBundleHandler;
use App\Services\AssetsBundle\Domain\Factory\CreateAssetFileEntityFactory;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use App\Services\AssetsBundle\Domain\Services\AssetsDriver\AssetDriverInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetBundleBuilder;
use App\Services\AssetsBundle\Infrastructure\Services\AssetBundleManager;
use App\Services\AssetsBundle\Infrastructure\Services\AssetBundleRegister;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\AssetDriver;
use App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\ViteAssetDriver;
use App\Services\AssetsBundle\Infrastructure\Services\Collections\CollectionAssetBundle;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AssetBundleProvider extends ServiceProvider implements ProviderInterface
{
    public function register(): void
    {
        $this->loadViewsFrom(
            base_path('app/views/assets'),
            'assets'
        );

        //Драйвер для разных типов сборок
        $this->app->register(
            config('view.assets.asset_driver_provider')
        );

        $this->app->bind(
            AppendAssetBundleHandler::class,
            AppendAssetBundleHandler::class
        );

        //Оркестратор
        $this->app->singleton(
            AssetsBundleManagerInterface::class,
            function ($app) {
                $collection = new CollectionAssetBundle();
                $driver = $app->make(AssetDriverInterface::class);
                $file = $app->make(Filesystem::class);
                $factory = new CreateAssetFileEntityFactory($file);
                $manager = new AssetBundleManager(
                    new AssetBundleBuilder(
                        $collection,
                        $driver,
                        $factory
                    ),
                    new AssetBundleRegister(
                        $collection,
                        $driver,
                    ),
                    $factory,
                );

                return $manager;
            }
        );
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('assetsBundleManager', $this->app->get(AssetsBundleManagerInterface::class));
        });
    }

    public static function serviceName(): string
    {
        return 'Assets';
    }

    public static function dependsServices(): array
    {
        return [];
    }
}
