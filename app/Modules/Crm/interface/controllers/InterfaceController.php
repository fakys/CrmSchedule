<?php

namespace App\Modules\Crm\interface\controllers;

use App\Assets\LayoutBundle;
use App\Src\modules\controllers\AbstractController;
use App\Src\modules\kernel\KernelModules;
use Illuminate\Routing\Controller;

class InterfaceController extends AbstractController
{
    public function actionIndex()
    {
        return view('interface::index');
    }

    static function loadController(KernelModules $kernel)
    {
        // TODO: Implement loadController() method.
    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }
}
