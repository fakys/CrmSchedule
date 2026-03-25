<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams;


use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;

class SelectElementAdditionalParams extends AbstractElementAdditionalParams
{

    private $multiple;

    public function __construct($multiple = false, $elementId = '',  array $elementClasses = [])
    {
        parent::__construct($elementId, $elementClasses, '');
        $this->multiple = $multiple;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }
}
