<?php
namespace App\Modules\Crm\interface\controllers;

use App\Modules\Crm\interface\InfoModule;
use App\Src\redis\Redis;
use Illuminate\Routing\Controller;

class InterfaceController extends Controller{
    public function __construct()
    {
        (new InfoModule())->runConfig();
    }
    public function actionIndex()
    {
        return view('index');
    }
}
