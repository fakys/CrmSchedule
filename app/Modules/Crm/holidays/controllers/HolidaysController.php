<?php
namespace App\Modules\Crm\holidays\controllers;

use App\Modules\Crm\holidays\model\AddHoliday;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class HolidaysController extends Controller{

    public function actionIndex()
    {
        $holidays = BackendHelper::getOperations()->getHolidaysForTable();
        return view('holidays::holidays.index', ['holidays' => $holidays]);
    }

    public function actionAddHoliday()
    {
        $format = BackendHelper::getRepositories()->getFullFormatLessons();
        return view('holidays::holidays.form_holiday', compact('format'));
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

    public function actionEditHoliday()
    {
        $id = request()->get('id');
        $holiday = BackendHelper::getRepositories()->getHolidayById($id);
        $format = BackendHelper::getRepositories()->getFullFormatLessons();
        return view('holidays::holidays.form_holiday', compact('format', 'holiday'));
    }

    public function editHoliday()
    {
        $model = new AddHoliday();
        $id = request()->post('id');
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if($validate->validate()){
            $model->pacePeriod();
            BackendHelper::getRepositories()->editHoliday($id, $model->name, $model->date_start, $model->date_end, $model->week_days, ($model->format==0)?null:$model->format, $model->description);
            return true;
        }
    }

    public function actionDeleteHoliday()
    {
        BackendHelper::getRepositories()->deleteHoliday(request()->post('id'));
    }
}
