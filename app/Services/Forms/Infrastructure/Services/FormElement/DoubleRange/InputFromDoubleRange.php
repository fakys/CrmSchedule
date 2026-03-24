<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement\DoubleRange;

use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class InputFromDoubleRange extends AbstractFormElement
{
    public function __construct(string $name, FormElementAdditionalParams $additionalParams, $value = '')
    {
        parent::__construct($name, null, $additionalParams, $value);
    }

    public function getAssets(): array
    {
        return [];
    }
    public function getTemplate(): string
    {
        return 'inputFromDoubleRangeField';
    }

    public function getTypeValue(): string
    {
        return self::NUMERIC_TYPE;
    }
}
