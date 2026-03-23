<?php
namespace App\Services\Forms\Domain\Services\AdditionalParams;

interface LabelAdditionalParamsInterface {
    public function getLabel(): string;
    public function getLabelId(): string|int;
    public function setLabel(string $label): void;
    public function setLabelId(string $labelId): void;
    public function getLabelClass(): array;
    public function setLabelClass(array $labelClass): void;
}
