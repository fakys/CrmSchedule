<?php
namespace App\Services\Views\Infrastructure\Services\Collections;


use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use Illuminate\Support\Collection;


/**
 *  Коллекция всех элементов страницы
 */
class ViewElementCollection
{
    protected Collection $collection;

    public function __construct()
    {
        $this->collection = new Collection();
    }

    public function getElements(): Collection
    {
        return $this->collection;
    }

    public function appendElementInCollection(ViewElementInterface $element)
    {
        $this->collection[$element->getTag()] = $element;
    }

    public function getElementByTag(string $tag): ViewElementInterface
    {
        return $this->collection[$tag];
    }

    public function hasElementByTag(string $tag): bool
    {
        return isset($this->collection[$tag]);
    }
}
