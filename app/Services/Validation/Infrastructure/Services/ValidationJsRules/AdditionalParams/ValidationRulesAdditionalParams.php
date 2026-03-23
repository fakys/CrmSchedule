<?php
namespace App\Services\Validation\Infrastructure\Services\ValidationJsRules\AdditionalParams;

use App\Services\Validation\Domain\Services\ValidationJsRules\ValidationRulesAdditionalParamsInterface;

class ValidationRulesAdditionalParams implements ValidationRulesAdditionalParamsInterface
{
    private $element_id = '';
    private $classes = [];
    private $attributes = [];

    public function getElementId(): string
    {
        return $this->element_id;
    }

    public function getElementClasses(): array
    {
        return $this->classes;
    }

    public function setElementId(string $elementId): void
    {
        $this->element_id = $elementId;
    }

    public function setElementClasses(array $elementClasses): void
    {
        $this->classes = $elementClasses;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
