<?php

namespace App\Services\Views\Infrastructure\Services\Elements\Abstracts;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;


abstract class AbstractViewNestedElement extends AbstractViewElement implements ViewNestedElementInterface
{
    protected $elements = [];

    /**
     * @return \App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface|\App\Services\Views\Domain\Services\Elements\ViewElementInterface[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    public function hasElement(string $tag): bool
    {
        return isset($this->elements[$tag]);
    }

    public function appendElements(ViewNestedElementInterface|ViewElementInterface $elements)
    {
        $this->elements[$elements->getTag()] = $elements;
    }

    public function getElementsByGroup($group): array
    {
        $elements = [];
        foreach ($this->elements as $element) {
            if ($element->getGroup() === $group) {
                $elements[] = $element;
            }
        }
        return $elements;
    }
}
