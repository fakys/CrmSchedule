<?php
namespace App\Services\Views\Domain\Services\Elements;


/** Элемент страницы */
interface ViewNestedElementInterface extends ViewElementInterface {

    /**
     * @return ViewNestedElementInterface|ViewElementInterface[]
     */
    public function getElements(): array;
    public function hasElement(string $tag): bool;
    public function appendElements(ViewNestedElementInterface|ViewElementInterface $elements);
    public function getElementsByGroup(string $group): array;
}
