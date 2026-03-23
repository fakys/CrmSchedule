<?php

namespace App\Services\Validation\Domain\Services\ValidationJsRules;

use App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface;

interface ValidationRulesAdditionalParamsInterface extends ViewElementAdditionalParamsInterface
{
    public function getAttributes(): array;
    public function setAttributes(array $attributes): void;
}
