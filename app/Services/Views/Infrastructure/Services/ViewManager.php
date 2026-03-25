<?php
namespace App\Services\Views\Infrastructure\Services;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;
use Illuminate\Contracts\Support\Htmlable;

/** Оркестратор страниц */
class ViewManager implements ViewManagerInterface
{
    public function __construct(
        private ViewBuilder $viewBuilder,
        private ViewRender $viewRender
    ){}

    public function appendElement(ViewNestedElementInterface|ViewElementInterface $element)
    {
        $this->viewBuilder->appendElement($element);
    }

    public function hasElementByTag(string $tag): bool
    {
        return $this->viewBuilder->hasElementByTag($tag);
    }

    public function getElementByTag(string $tag): ViewElementInterface|ViewNestedElementInterface
    {
        return $this->viewBuilder->getElementByTag($tag);
    }

    public function renderElement(ViewElementInterface $element): Htmlable
    {
        return $this->viewRender->renderElement($element);
    }

    public function renderElementByTag($tag): Htmlable
    {
        return $this->viewRender->renderElementByTag($tag);
    }
}
