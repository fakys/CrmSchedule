<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts;

use App\Services\Forms\Domain\Services\AdditionalParams\FormElementAdditionalParamsInterface;

abstract class AbstractElementAdditionalParams implements FormElementAdditionalParamsInterface
{
    private $element_id;
    private $element_classes;
    private $placeholder;

    public function __construct(string $element_id = '', array $element_classes = [], $placeholder = '')
    {
        $this->element_id = $element_id;
        $this->element_classes = $element_classes;
        $this->placeholder = $placeholder;
    }


    public function getElementId(): string
    {
        return $this->element_id;
    }

    public function getElementClasses(): array
    {
        return $this->element_classes;
    }

    public function setElementId(string $elementId): void
    {
        $this->element_id = $elementId;
    }

    public function setElementClasses(array $elementClasses): void
    {
        $this->element_classes = $elementClasses;
    }
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }
}
