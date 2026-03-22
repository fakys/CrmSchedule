<?php
namespace App\Services\AssetsBundle\Infrastructure\Services\AssetViteDriver\RegisterPlugins;

use App\Services\AssetsBundle\Domain\Services\AssetsDriver\RegisterPluginInterface;
use Illuminate\Foundation\Vite;
use Illuminate\Support\HtmlString;

class ViteRegisterCssPlugin implements RegisterPluginInterface
{
    public function __construct(
        private Vite $vite
    ){}

    public static function pluginType(): string
    {
        return 'css';
    }

    /**
     * @throws \Exception
     */
    public function registerFile($file): HtmlString
    {
        $vite = $this->vite;
        return $vite($file);
    }

    public function registerScript(string $script): HtmlString
    {
        /** todo Сделать регистрацию через скрипт */
        return new HtmlString();
    }
}
