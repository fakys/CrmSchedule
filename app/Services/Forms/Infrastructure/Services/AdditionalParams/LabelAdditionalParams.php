<?php
namespace App\Services\Forms\Infrastructure\Services\AdditionalParams;


class LabelAdditionalParams implements \App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface
{
    private $label;
    private $label_id;
    private $label_class;

    public function __construct(string $label = '', string|int $label_id = '', array $label_class = [])
    {
        $this->label = $label;
        $this->label_id = $label_id;
        $this->label_class = $label_class;
    }


    public function getLabel(): string
    {
        return $this->label;
    }

    public function getLabelId(): string|int
    {
        return $this->label_id;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setLabelId(string $labelId): void
    {
        $this->label_id = $labelId;
    }

    public function getLabelClass(): array
    {
        return $this->label_class;
    }

    public function setLabelClass(array $labelClass): void
    {
        $this->label_class = $labelClass;
    }
}
