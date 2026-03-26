<?php

namespace App\Services\Table\Providers;

use App\Services\Forms\Domain\Services\FormLoader\FormLoaderInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataBuilderInterface;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;
use App\Services\Forms\Infrastructure\Services\FromLoader\FormLoader;
use App\Services\Forms\Infrastructure\Services\FromReturnData\FromReturnDataBuilder;
use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\Table\Infrastructure\Services\AbstractTable;
use App\Services\Views\Providers\ViewProvider;
use Illuminate\Support\ServiceProvider;

class TableProvider extends ServiceProvider implements ProviderInterface
{
    public function register()
    {
        $this->loadViewsFrom(base_path('app/views/table'), AbstractTable::BASE_TABLE_PREFIX);
    }

    public static function serviceName(): string
    {
        return 'table';
    }

    public static function dependsServices(): array
    {
        return [
            ViewProvider::serviceName(),
            \App\Services\AssetsBundle\Providers\AssetBundleProvider::serviceName()
        ];
    }
}
