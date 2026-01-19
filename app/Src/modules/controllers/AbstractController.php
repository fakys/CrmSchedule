<?php
namespace App\Src\modules\controllers;

use App\Src\modules\kernel\KernelConstructor;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller {

    /**
     * @param KernelConstructor $kernel
     */
    abstract static function loadController(KernelConstructor $kernel);
}
