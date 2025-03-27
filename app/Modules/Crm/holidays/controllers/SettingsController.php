<?php
namespace App\Modules\Crm\holidays\controllers;

use App\Modules\Crm\holidays\model\HolidaySetting;
use App\Modules\Crm\system_settings\models\CrmSetting;
use App\Src\BackendHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function actionIndex()
    {
        $setting = BackendHelper::getSystemSettings(HolidaySetting::getSettingName())->getSettings();
        return view('settings.index_settings', compact('setting'));
    }

    public function getHolidaysForm()
    {
        $number = request('number');
        $for_settings = request('for_settings');
        $setting = BackendHelper::getSystemSettings(HolidaySetting::getSettingName())->getSettings();
        $format = BackendHelper::getRepositories()->getFullFormatLessons();
        $min_date = new \DateTime();
        $min_date->setDate($min_date->format('Y'), 1, 1);
        $max_date = new \DateTime();
        $max_date->setDate($min_date->format('Y'), 12, 31);
        return view('settings.holidays_form', compact('number', 'for_settings', 'setting', 'format', 'min_date', 'max_date'));
    }

    public function setHolidays()
    {
        $model = new HolidaySetting();
        $model->load(request()->post());
        $model->holidayValidate();
        return BackendHelper::getOperations()->createSystemSettings(
            ['name'=>HolidaySetting::getSettingName(), 'settings'=>$model->getData(), 'create_user_id'=>context()->getUser()->id, 'active'=>true]
        );
    }
}
