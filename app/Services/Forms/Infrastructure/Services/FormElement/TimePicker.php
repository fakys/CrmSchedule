<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;


use App\Assets\TimePickerBundle;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class TimePicker extends AbstractFormElement
{
    public function __construct(string $name, LabelAdditionalParamsInterface $label, AbstractElementAdditionalParams $additionalParams, ?string $value = '')
    {
        parent::__construct($name, $label, $additionalParams, $value);
    }

    public function getAssets(): array
    {
        return [
            TimePickerBundle::class
        ];
    }

    public function getTemplate(): string
    {
        return 'timePickerField';
    }

    public function getTypeValue(): string
    {
        return self::STRING_TYPE;
    }
}
