<?php
namespace App\Services\Validation\Infrastructure\Services\ValidationJsRules;

use App\Services\Abstracts\Infrastructure\Assets\AssetJsValidateBundle;
use App\Services\Validation\Infrastructure\Services\ValidationJsRules\Abstracts\AbstractRule;

class RequiredRule extends AbstractRule
{
    public function getAssets(): array
    {
        return [
            new AssetJsValidateBundle()
        ];
    }

    public static function ruleName(): string
    {
        return 'required';
    }
}
