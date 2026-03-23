<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams;


use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;

class SelectElementAdditionalParams extends AbstractElementAdditionalParams
{

    public function __construct($elementId = '', array $elementClasses = [], $placeholder = '')
    {
        parent::__construct($elementId, $elementClasses, $placeholder);
    }
}
