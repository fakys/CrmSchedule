<?php
namespace App\Services\Views\Infrastructure\Services;

use App\Services\AssetsBundle\Application\Commands\AppendAssetBundleHandler;
use App\Services\AssetsBundle\Application\DTO\AppendAssetBundleDto;
use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;
use App\Services\Views\Infrastructure\Services\Collections\ViewElementCollection;

class ViewBuilder
{
    public function __construct(
        private ViewElementCollection $collection,
        private AppendAssetBundleHandler $assetsHandler,
    ){}

    /**
     * Загружаем элемент в коллекцию
     * @param \App\Services\Views\Domain\Services\Elements\ViewElementInterface $element
     * @param $tag
     * @return void
     */
    public function appendElement(ViewNestedElementInterface|ViewElementInterface $element)
    {
        $this->collection->appendElementInCollection($element);

        //И так же подгружаем его стили
        $this->assetsHandler->handle(new AppendAssetBundleDto($element->getAssets()));

        if ($element instanceof ViewNestedElementInterface) {
            foreach ($element->getElements() as $element) {
                $this->appendElement($element);
            }
        }
    }

    public function getElementByTag(string $tag): ViewElementInterface
    {
        return $this->collection->getElementByTag($tag);
    }

    public function hasElementByTag(string $tag): bool
    {
        return $this->collection->hasElementByTag($tag);
    }
}
