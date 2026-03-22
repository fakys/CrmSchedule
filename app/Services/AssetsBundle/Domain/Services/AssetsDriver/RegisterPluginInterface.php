<?php

namespace App\Services\AssetsBundle\Domain\Services\AssetsDriver;

use Illuminate\Support\HtmlString;

interface RegisterPluginInterface
{
    /**
     * Тип файла (js, css, scss...)
     * @return string
     */
    public static function pluginType(): string;

    /**
     * Регистрация файла
     * @param $file
     * @return HtmlString
     */
    public function registerFile($file): HtmlString;

    /**
     * Регистер скрипта "тег style или script"
     * @param string $script
     * @return HtmlString
     */
    public function registerScript(string $script): HtmlString;
}
