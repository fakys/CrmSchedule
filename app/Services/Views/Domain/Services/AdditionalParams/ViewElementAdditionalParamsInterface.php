<?php
namespace App\Services\Views\Domain\Services\AdditionalParams;

interface ViewElementAdditionalParamsInterface {
    public function getElementId(): string;

    public function getElementClasses(): array;

    public function setElementId(string $elementId): void;
    public function setElementClasses(array $elementClasses): void;
}
