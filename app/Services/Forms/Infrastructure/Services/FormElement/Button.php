<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement;

use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;

class Button extends AbstractFormElement
{
    protected $text;
    protected $type;

    public function __construct(string $text, string $name, AbstractElementAdditionalParams $additionalParams, $type = 'submit')
    {
        parent::__construct($name, null, $additionalParams);
        $this->text = $text;
        $this->type = $type;
    }

    public function getText(): string
    {
        return $this->text;
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
        return 'buttonField';
    }

    public function getTypeValue(): string
    {
        return '';
    }
}
