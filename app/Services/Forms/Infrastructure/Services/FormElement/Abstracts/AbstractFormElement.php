<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement\Abstracts;


use App\Services\Forms\Domain\Services\AdditionalParams\FormElementAdditionalParamsInterface;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Domain\Services\FormElements\FormElementInterface;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;

abstract class AbstractFormElement extends AbstractViewNestedElement implements FormElementInterface
{
    const PREFIX_ELEMENTS = 'PrefixElements';

    /**
     * Типы данных
     */
    const NUMERIC_TYPE = 'numeric';
    const STRING_TYPE = 'string';
    const FILE_TYPE = 'file';
    const ARRAY_TYPE = 'array';
    const BOOLEAN_TYPE = 'boolean';


    protected $value;
    protected string $name;

    protected $tag;

    protected ?LabelAdditionalParamsInterface $label;


    public function __construct(
        $name,
        ?LabelAdditionalParamsInterface $label,
        ?FormElementAdditionalParamsInterface $additionalParams,
        $value = null,
    )
    {
        $this->label = $label;
        $this->value = $value;
        $this->name = $name;
        $this->additionalParams = $additionalParams;
        $this->tag = $name;
    }

    public function getPrefixTemplate(): string
    {
        return self::PREFIX_ELEMENTS;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getLabel(): ?LabelAdditionalParamsInterface
    {
        return $this->label;
    }

    public function getAdditionalParams(): ?FormElementAdditionalParamsInterface
    {
        return $this->additionalParams;
    }

    public function getTag(): string
    {
        return $this->tag;
    }
    abstract public function getTypeValue(): string;
}
