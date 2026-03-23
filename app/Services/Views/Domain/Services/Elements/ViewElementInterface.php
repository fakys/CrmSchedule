<?php
namespace App\Services\Views\Domain\Services\Elements;

use App\Services\Views\Domain\Services\AdditionalParams\ViewElementAdditionalParamsInterface;

/** Элемент страницы */
interface ViewElementInterface {
    /**
     * @return \App\Services\AssetsBundle\Domain\Services\AssetBundleInterface[]
     */
    public function getAssets(): array;
    public function getTemplate(): string;
    public function getPrefixTemplate(): string;
    public function getTag(): string;
    public function getAdditionalParams(): ?ViewElementAdditionalParamsInterface;
    public function getGroup(): string;
    public function setGroup(string $group): void;
    public function getAccess(): string;
    public function setAccess(string $cid): void;
}
