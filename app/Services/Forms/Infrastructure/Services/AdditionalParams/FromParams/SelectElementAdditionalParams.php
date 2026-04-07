<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams;


use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;

class SelectElementAdditionalParams extends AbstractElementAdditionalParams
{

    private $multiple;
    private $disabled;

    public function __construct($multiple = false, $elementId = '',  array $elementClasses = [], $disabled = false)
    {
        parent::__construct($elementId, $elementClasses, '');
        $this->multiple = $multiple;
        $this->disabled = $disabled;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function getDisabled()
    {
        return $this->disabled;
    }
}
