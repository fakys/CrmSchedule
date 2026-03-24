<?php

namespace App\Services\Validation\Infrastructure\Services\ValidationJsRules\Abstracts;

use App\Services\Validation\Domain\Services\ValidationJsRules\ValidationJsRulesInterface;
use App\Services\Validation\Domain\Services\ValidationJsRules\ValidationRulesAdditionalParamsInterface;
use App\Services\Validation\Infrastructure\Services\Assets\AssetJsValidateBundle;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewElement;

abstract class AbstractRule extends AbstractViewElement implements ValidationJsRulesInterface
{
    public function __construct(ValidationRulesAdditionalParamsInterface $additionalParams)
    {
        $this->additionalParams = $additionalParams;
    }

    public function getAssets(): array
    {
        return [
            new AssetJsValidateBundle()
        ];
    }

    const PREFIX_TEMPLATE = 'RulesTemplate';

    protected $field;
    protected $field_ru_name = '';

    protected $field_type;

    public function setFieldName(string $fieldName)
    {
        $this->field = $fieldName;
    }

    public function getAdditionalParams(): ValidationRulesAdditionalParamsInterface
    {
        return $this->additionalParams;
    }

    public function getFieldName(): string
    {
        return $this->field;
    }

    public function setRule(string $rule){}

    public function getPrefixTemplate(): string
    {
        return self::PREFIX_TEMPLATE;
    }

    public function getTemplate(): string
    {
        return 'validate_rule';
    }

    public function getTag(): string
    {
        return $this->field.'_'.$this->ruleName();
    }

    public function getMessage(): string
    {
        $message = $this->getValidateRuMessages()[$this->ruleName()];

        return str_replace(':attribute', $this->getFieldRuName(), $message);
    }

    protected function getValidateRuMessages(): array
    {

        return require config('validation')['validation_ru_messages_path'];
    }

    public function setFieldRuName(string $fieldRuName)
    {
        $this->field_ru_name = $fieldRuName;
    }

    public function getFieldRuName(): string
    {
        return $this->field_ru_name;
    }

    public function getType(): string
    {
        return $this->field_type;
    }

    public function setType(string $type)
    {
        $this->field_type = $type;
    }
}
