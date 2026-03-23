<?php
namespace App\Services\Forms\Domain\Services\FormElements;

use App\Services\Forms\Domain\Services\AdditionalParams\FormElementAdditionalParamsInterface;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;

interface FormElementInterface extends ViewNestedElementInterface {
    public function getName(): string;

    public function getValue();
    public function setValue($value);

    public function getLabel(): ?LabelAdditionalParamsInterface;
    public function getAdditionalParams(): ?FormElementAdditionalParamsInterface;
}
