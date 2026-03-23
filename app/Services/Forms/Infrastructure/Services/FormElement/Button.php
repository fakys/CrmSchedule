<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class Button extends AbstractFormElement
{
    protected $text;
    public function __construct(string $text, string $name, AbstractElementAdditionalParams $additionalParams)
    {
        parent::__construct($name, null, $additionalParams);
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAssets(): array
    {
        return [];
    }
    public function getTemplate(): string
    {
        return 'buttonField';
    }

    public function getTypeValue(): string
    {
        return '';
    }
}
