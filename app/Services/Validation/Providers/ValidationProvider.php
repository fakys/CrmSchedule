<?php
namespace App\Services\Validation\Providers;

use App\Services\Forms\Providers\FromManagerProvider;
use App\Services\ProviderLoader\Domain\Services\ProviderInterface;
use App\Services\Validation\Domain\Services\Factory\ValidationBuilderFactoryInterface;
use App\Services\Validation\Domain\Services\Factory\ValidationJsBuilderFactoryInterface;
use App\Services\Validation\Domain\Services\RuleFormaterInterface;
use App\Services\Validation\Domain\Services\ValidationJsRules\ValidationRulesAdditionalParamsInterface;
use App\Services\Validation\Infrastructure\Services\Factory\ValidationBuilderFactory;
use App\Services\Validation\Infrastructure\Services\Factory\ValidationJsBuilderFactory;
use App\Services\Validation\Infrastructure\Services\RuleFormater;
use App\Services\Validation\Infrastructure\Services\ValidationJsBuilder;
use App\Services\Validation\Infrastructure\Services\ValidationJsRules\Abstracts\AbstractRule;
use App\Services\Validation\Infrastructure\Services\ValidationJsRules\AdditionalParams\ValidationRulesAdditionalParams;
use App\Services\Validation\Infrastructure\Services\ValidationJsRules\MinLengthRule;
use App\Services\Validation\Infrastructure\Services\ValidationJsRules\RequiredRule;
use Illuminate\Support\ServiceProvider;

class ValidationProvider extends ServiceProvider implements ProviderInterface {
    public function register(): void
    {
        $this->app->bind(
            ValidationBuilderFactoryInterface::class,
            ValidationBuilderFactory::class
        );

        $this->app->bind(
            ValidationJsBuilderFactoryInterface::class,
            ValidationJsBuilderFactory::class
        );

        $this->app->bind(
            RuleFormaterInterface::class,
            RuleFormater::class
        );

        $this->app->bind(
            ValidationRulesAdditionalParamsInterface::class,
            ValidationRulesAdditionalParams::class
        );

        //Правила
        $this->app->bind(
            ValidationJsBuilder::PREFIX.'.'.RequiredRule::ruleName(),
            RequiredRule::class
        );
        $this->app->bind(
            ValidationJsBuilder::PREFIX.'.'.MinLengthRule::ruleName(),
            MinLengthRule::class
        );

        $this->loadViewsFrom(
            base_path('resources/views/services/validate_rules'),
            AbstractRule::PREFIX_TEMPLATE
        );
    }

    public function boot()
    {

    }

    public static function serviceName(): string
    {
        return 'Validation';
    }

    public static function dependsServices(): array
    {
        return [
            FromManagerProvider::serviceName(),
            \App\Services\Views\Providers\ViewProvider::serviceName(),
            \App\Services\AssetsBundle\Providers\AssetBundleProvider::serviceName()
        ];
    }
}
