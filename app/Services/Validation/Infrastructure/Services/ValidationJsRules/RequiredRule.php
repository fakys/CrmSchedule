<?php
namespace App\Services\Validation\Infrastructure\Services\ValidationJsRules;

use App\Services\Validation\Infrastructure\Services\ValidationJsRules\Abstracts\AbstractRule;

class RequiredRule extends AbstractRule
{
    public static function ruleName(): string
    {
        return 'required';
    }
}
