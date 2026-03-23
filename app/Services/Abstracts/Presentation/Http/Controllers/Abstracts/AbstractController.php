<?php

namespace App\Services\Abstracts\Presentation\Http\Controllers\Abstracts;

use App\Services\Views\Domain\Services\ViewManagerInterface;
use App\Services\AssetsBundle\Application\Commands\AppendAssetBundleHandler;
use App\Services\AssetsBundle\Application\DTO\AppendAssetBundleDto;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller
{
    public function __construct(
        protected ViewManagerInterface $viewManager,
        protected AppendAssetBundleHandler $assetHandler
    )
    {
        //Загружаем нужные стили для контроллера
        $this->assetHandler->handle(new AppendAssetBundleDto($this->assetsBundles()));
    }

    abstract protected function assetsBundles(): array;
}

