<?php
namespace App\Modules\Crm\holidays\controllers;

use App\Modules\Crm\holidays\model\AddHoliday;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class HolidaysController extends Controller{

    public function actionIndex()
    {
        return view('holidays.index');
    }

    public function actionAddHoliday()
    {
        $format = BackendHelper::getRepositories()->getFullFormatLessons();
        return view('holidays.add_holiday', compact('format'));
    }

    public function addHoliday()
    {
        $model = new AddHoliday();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            $model->pacePeriod();
            BackendHelper::getRepositories()->createHoliday($model->name, $model->date_start, $model->date_end, $model->week_days, ($model->format==0)?null:$model->format, $model->description);
        }
    }
}
