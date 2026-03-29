<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Assets\PeriodDatePickerBundle;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class PeriodDatePicker extends AbstractFormElement
{

    public function __construct(string $name, LabelAdditionalParams $label, AbstractElementAdditionalParams $additionalParams)
    {
        parent::__construct($name, $label, $additionalParams);
    }

    public function getAssets(): array
    {
        return [PeriodDatePickerBundle::class];
    }
    public function getTemplate(): string
    {
        return 'periodDatePicker';
    }

    public function getTypeValue(): string
    {
        return self::STRING_TYPE;
    }
}
