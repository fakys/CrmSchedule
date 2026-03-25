<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Assets\SelectDuallistboxBundle;
use App\Services\Forms\Domain\Services\AdditionalParams\FormElementAdditionalParamsInterface;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

/**
 * @method SelectElementAdditionalParams getAdditionalParams()
 */
class SelectDuallistbox extends AbstractFormElement
{
    private array $options = [];
    public function __construct(string $name, $options, LabelAdditionalParamsInterface $label, SelectElementAdditionalParams $additionalParams, ?array $value = [])
    {
        parent::__construct($name, $label, $additionalParams, $value);
        $this->options = $options;
    }

    public function getAssets(): array
    {
        return [
            SelectDuallistboxBundle::class,
        ];
    }

    public function getTemplate(): string
    {
        return 'selectDuallistbox';
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getTypeValue(): string
    {
        return self::ARRAY_TYPE;
    }
}
