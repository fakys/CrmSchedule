<?php
namespace App\Services\Validation\Domain\Services\ValidationJsRules;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;

interface ValidationJsRulesInterface extends ViewElementInterface
{
    public function getFieldName(): string;
    public function setFieldName(string $fieldName);
    public function setFieldRuName(string $fieldRuName);
    public function getFieldRuName(): string;
    public function setRule(string $rule);

    //название правила ОБЯЗАТЕЛЬНО должно быть как правила валидации в laravel
    public static function ruleName(): string;

    public function getMessage(): string;

    public function getType(): string;
    public function setType(string $type);
}
