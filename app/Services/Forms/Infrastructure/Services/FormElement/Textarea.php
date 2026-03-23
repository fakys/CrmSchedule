<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;


use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class Textarea extends AbstractFormElement
{
    public function __construct(string $name, LabelAdditionalParamsInterface $label, AbstractElementAdditionalParams $additionalParams, ?string $value = '')
    {
        parent::__construct($name, $label, $additionalParams, $value);
    }

    public function getAssets(): array
    {
        return [];
    }

    public function getTemplate(): string
    {
        return 'textareaField';
    }

    public function getTypeValue(): string
    {
        return self::STRING_TYPE;
    }
}
