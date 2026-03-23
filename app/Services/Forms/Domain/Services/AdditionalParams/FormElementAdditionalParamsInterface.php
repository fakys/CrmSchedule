<?php
namespace App\Services\Forms\Domain\Services\AdditionalParams;

interface FormElementAdditionalParamsInterface extends \App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface {
    public function getPlaceholder();

    public function setPlaceholder(string $placeholder);
}
