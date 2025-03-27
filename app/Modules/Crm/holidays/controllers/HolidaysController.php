<?php
namespace App\Modules\Crm\holidays\controllers;

use Illuminate\Routing\Controller;

class HolidaysController extends Controller{

    public function actionIndex()
    {
        return view('holidays.index');
    }
}
