<?php

namespace App\Services\AssetsBundle\Domain\Services;


use App\Services\AssetsBundle\Domain\Services\AssetBundleInterface;
use Illuminate\Support\HtmlString;

interface AssetsBundleManagerInterface
{
    //Регистрируем стили
    public function appendBundle(AssetBundleInterface $bundle);

    //Вызываем стили шапки
    public function registerHeaderFiles(): HtmlString;

    //Вызываем стили тела
    public function registerBodyFiles(): HtmlString;

    public function registerFile(string $filePath): HtmlString;
}
