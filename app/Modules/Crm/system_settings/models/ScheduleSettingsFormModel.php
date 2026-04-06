<?php

namespace App\Modules\Crm\system_settings\models;

use App\Assets\BaseLayoutBundle;
use App\Modules\Crm\auth\models\formsReturnData\LoginFormReturnData;
use App\Modules\Crm\backend_module\enums\FormatLessonEnum;
use App\Modules\Crm\system_settings\components\settings\ScheduleSetting;
use App\Modules\Crm\system_settings\models\returnData\ScheduleSettingsReturnData;
use App\Modules\Crm\system_settings\models\returnData\SystemSettingsReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\Select;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;

class ScheduleSettingsFormModel extends AbstractForm
{
    public function getAssets(): array
    {
        return [
            BaseLayoutBundle::class,
        ];
    }

    public function getAttribute(): array
    {
        return [
            'users_groups',
            'type_weeks',
            'default_format'
        ];
    }

    public function returnData(): string
    {
        return ScheduleSettingsReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new SelectSearch(
                'users_groups',
                ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id'),
                new LabelAdditionalParams('Группы преподавателей'),
                new SelectElementAdditionalParams(true)
            ),
        );

        $this->appendElements(
            new Select(
                'type_weeks',
                [ScheduleSetting::SIX_DAY, ScheduleSetting::FIVE_DAY],
                new LabelAdditionalParams('Тип по которому будет отображаться расписание'),
                new SelectElementAdditionalParams()
            ),
        );

        $this->appendElements(
            new Select(
                'default_format',
                [FormatLessonEnum::FACE_TO_FACE => 'Очная пара', FormatLessonEnum::CORRESPONDENCE_COURSES => 'Заочная пара'],
                new LabelAdditionalParams('Базовый формат пары'),
                new SelectElementAdditionalParams()
            ),
        );

        $this->appendElements(
            new Button('Сохранить', 'submit', new FormElementAdditionalParams())
        );
    }
}

