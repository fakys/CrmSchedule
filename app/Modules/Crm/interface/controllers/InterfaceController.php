<?php
namespace App\Modules\Crm\interface\controllers;

use App\Src\redis\Redis;
use Illuminate\Routing\Controller;

class InterfaceController extends Controller{
    public function actionIndex()
    {
        return view('index');
    }
}
