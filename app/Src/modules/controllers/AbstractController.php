<?php
namespace App\Src\modules\controllers;

use App\Src\modules\kernel\KernelModules;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller {

    /**
     * @param KernelModules $kernel
     */
    abstract static function loadController(KernelModules $kernel);
}
