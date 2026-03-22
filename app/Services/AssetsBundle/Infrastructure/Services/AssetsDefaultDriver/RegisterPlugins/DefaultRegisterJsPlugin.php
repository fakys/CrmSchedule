<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\RegisterPlugins;

use App\Services\AssetsBundle\Domain\Services\AssetsDriver\RegisterPluginInterface;
use App\Services\AssetsBundle\Infrastructure\Services\AssetsDefaultDriver\AssetDriver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

class DefaultRegisterJsPlugin implements RegisterPluginInterface
{
    public static function pluginType(): string
    {
        return 'js';
    }

    public function registerFile($file): HtmlString
    {
        return new HtmlString(View::make(AssetDriver::TEMPLATES_PATH.'.tag_file_js', ['path' => $file])->toHtml());
    }

    public function registerScript(string $script): HtmlString
    {
        /** todo Сделать регистрацию через скрипт */
        return new HtmlString();
    }
}
