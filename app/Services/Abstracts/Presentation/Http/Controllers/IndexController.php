<?php
namespace App\Services\Abstracts\Presentation\Http\Controllers;

use App\Services\Abstracts\Infrastructure\Assets\AssetMainBundle;
use App\Services\Abstracts\Presentation\Http\Controllers\Abstracts\AbstractController;

class IndexController extends AbstractController {

    protected function assetsBundles(): array
    {
        return [
            new AssetMainBundle(),
        ];
    }

    public function actionIndex()
    {
        return view('core::index');
    }
}
