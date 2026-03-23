<?php

namespace App\Services\Forms\Infrastructure\Services\FormElement\DoubleRange;

use App\Domains\User\Infrastructure\Assets\AssetSettingsUserBundle;
use App\Services\Forms\Domain\Services\AdditionalParams\LabelAdditionalParamsInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\DoubleRangeElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FromElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Abstracts\AbstractFormElement;
use App\Services\Views\Infrastructure\Services\Elements\Abstracts\AbstractViewNestedElement;

/**
 * @method DoubleRangeElementAdditionalParams getAdditionalParams()
 */
class DoubleRange extends AbstractViewNestedElement
{
    private int $min;
    private int $max;
    private int $step;
    private $labels;

    public function __construct(string $name, $min, $max, $step, LabelAdditionalParamsInterface $label, DoubleRangeElementAdditionalParams $additionalParams, ?array $value = [])
    {
        $this->additionalParams = $additionalParams;
        $this->tag = $name;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->labels = $label;

        $this->appendElements(
            new InputFromDoubleRange($additionalParams->getMinName(), new FromElementAdditionalParams())
        );
        $this->appendElements(
            new InputFromDoubleRange($additionalParams->getMaxName(), new FromElementAdditionalParams())
        );
    }

    public function getAssets(): array
    {
        return [
            new AssetSettingsUserBundle()
        ];
    }

    public function getTemplate(): string
    {
        return 'doubleRange';
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function getLabel(): LabelAdditionalParamsInterface
    {
        return $this->labels;
    }

    public function getPrefixTemplate(): string
    {
        return AbstractFormElement::DEFAULT_PREFIX_ELEMENTS;
    }
}
