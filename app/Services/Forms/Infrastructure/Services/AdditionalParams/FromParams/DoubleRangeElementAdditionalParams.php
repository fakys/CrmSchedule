<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams;


use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\Abstracts\AbstractElementAdditionalParams;

class DoubleRangeElementAdditionalParams extends AbstractElementAdditionalParams
{
    private $min_name;

    private $max_name;

    public function __construct($elementId = '', $max_name = 'max_range', $min_name = 'min_range', array $elementClasses = [], $placeholder = '')
    {
        parent::__construct($elementId, $elementClasses, $placeholder);
        $this->min_name = $min_name;
        $this->max_name = $max_name;
    }

    public function getMinName()
    {
        return $this->min_name;
    }

    public function setMinName($min_name)
    {
        $this->min_name = $min_name;
    }

    public function getMaxName()
    {
        return $this->max_name;
    }

    public function setMaxName($max_name)
    {
        $this->max_name = $max_name;
    }
}
