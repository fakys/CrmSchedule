<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Assets\SelectSearchBundle;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

/**
 * Селект с поиском
 */
class SelectSearch extends AbstractFormElement
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
            SelectSearchBundle::class
        ];
    }

    public function getTemplate(): string
    {
        return 'selectSearchField';
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
