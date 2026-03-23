<?php
namespace App\Services\Views\Infrastructure\Services;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Infrastructure\Services\Collections\ViewElementCollection;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\View\Factory;

class ViewRender
{
    public function __construct(
        protected ViewElementCollection $viewElementCollection,
        protected Factory $view,
    ){}


    public function renderElement(ViewElementInterface $element): Htmlable
    {
        return $this->view->make(sprintf('%s::%s', $element->getPrefixTemplate(), $element->getTemplate()), ['element' => $element]);
    }

    public function renderElementByTag($tag): Htmlable
    {
        $element = $this->viewElementCollection->getElementByTag($tag);
        return $this->renderElement($element);
    }
}
