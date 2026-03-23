<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class Input extends AbstractFormElement
{
    const NUMBER_INPUT_TYPE = 'number';
    const FILE_INPUT_TYPE = 'file';

    private string $type;

    public function __construct(string $type, string $name, LabelAdditionalParamsInterface $label, AbstractElementAdditionalParams $additionalParams, $value = '')
    {
        parent::__construct($name, $label, $additionalParams, $value);
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAssets(): array
    {
        return [];
    }
    public function getTemplate(): string
    {
        return 'inputField';
    }

    public function getTypeValue(): string
    {
        if (self::NUMBER_INPUT_TYPE === $this->type) {
            return self::NUMERIC_TYPE;
        } elseif (self::FILE_INPUT_TYPE === $this->type) {
            return self::FILE_TYPE;
        } else {
            return self::STRING_TYPE;
        }

    }
}
