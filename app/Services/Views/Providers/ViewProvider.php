<?php

namespace App\Services\Views\Providers;

use App\Services\AssetsBundle\Application\Commands\AppendAssetBundleHandler;
use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;
use App\Services\Views\Infrastructure\Services\Collections\ViewElementCollection;
use App\Services\Views\Infrastructure\Services\ViewBuilder;
use App\Services\Views\Infrastructure\Services\ViewManager;
use App\Services\Views\Infrastructure\Services\ViewRender;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;

class ViewProvider extends ServiceProvider implements ProviderInterface
{
    public function register(): void
    {
        $this->app->singleton(
            ViewManagerInterface::class,
            function ($app) {
                $collection = new ViewElementCollection();
                $assetHandler = $app->make(AppendAssetBundleHandler::class);
                $manager = new ViewManager(
                    new ViewBuilder($collection, $assetHandler),
                    new ViewRender($collection, $app->make(Factory::class)),
                );
                return $manager;
            }
        );
        $this->loadViewsFrom(base_path('app/views/html'), 'HTML');
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('viewManager', $this->app->get(ViewManagerInterface::class));
        });
    }

    public static function serviceName(): string
    {
        return 'View';
    }

    public static function dependsServices(): array
    {
        return [
            \App\Services\AssetsBundle\Providers\AssetBundleProvider::serviceName()
        ];
    }
}
