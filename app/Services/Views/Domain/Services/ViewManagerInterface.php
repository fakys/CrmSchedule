<?php
namespace App\Services\Views\Domain\Services;


use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;
use Illuminate\Contracts\Support\Htmlable;

interface ViewManagerInterface {
    public function appendElement(ViewNestedElementInterface|ViewElementInterface $element);
    public function hasElementByTag(string $tag): bool;
    public function renderElement(ViewElementInterface $element): Htmlable;
    public function renderElementByTag(string $tag): Htmlable;

}
