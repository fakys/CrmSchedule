<?php

namespace App\Services\Forms\Providers;

use App\Services\Forms\Domain\Services\FormLoader\FormLoaderInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataBuilderInterface;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;
use App\Services\Forms\Infrastructure\Services\FromLoader\FormLoader;
use App\Services\Forms\Infrastructure\Services\FromReturnData\FromReturnDataBuilder;
use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\Views\Providers\ViewProvider;
use Illuminate\Support\ServiceProvider;

class FromManagerProvider extends ServiceProvider implements ProviderInterface
{
    public function register()
    {
        $this->app->bind(FormLoaderInterface::class, FormLoader::class);
        $this->app->bind(FromReturnDataBuilderInterface::class, FromReturnDataBuilder::class);
        $this->loadViewsFrom(base_path('resources/views/services/forms/default_form'), AbstractForm::DEFAULT_FORM_PREFIX);
        $this->loadViewsFrom(base_path('resources/views/services/forms/fields'), AbstractFormElement::DEFAULT_PREFIX_ELEMENTS);
    }

    public static function serviceName(): string
    {
        return 'fromManager';
    }

    public static function dependsServices(): array
    {
        return [
            ViewProvider::serviceName(),
            \App\Services\AssetsBundle\Providers\AssetBundleProvider::serviceName()
        ];
    }
}
