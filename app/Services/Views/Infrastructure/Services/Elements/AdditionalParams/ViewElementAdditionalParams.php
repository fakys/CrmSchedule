<?php

namespace App\Services\Views\Infrastructure\Services\Elements\AdditionalParams;

class ViewElementAdditionalParams implements \App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface
{
    public function __construct($element_id = '', $element_class = [])
    {
        $this->element_id = $element_id;
        $this->element_class = $element_class;
    }

    protected $element_id = '';

    protected $element_class = [];

    public function getElementId(): string
    {
        return $this->element_id;
    }

    public function getElementClasses(): array
    {
        return $this->element_class;
    }

    public function setElementId(string $elementId): void
    {
        $this->element_id = $elementId;
    }

    public function setElementClasses(array $elementClasses): void
    {
        $this->element_class = $elementClasses;
    }
}
