<?php
namespace App\Modules\Crm\system_settings\models;

use App\Assets\BaseLayoutBundle;
use App\Modules\Crm\system_settings\components\settings\CrmSetting;
use App\Modules\Crm\system_settings\models\returnData\CrmSettingsReturnData;
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

class CrmSettingsFormModel extends AbstractForm
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
            'system_users',
            'system_user_groups',
        ];
    }

    public function returnData(): string
    {
        return CrmSettingsReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new SelectSearch('system_users', ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllActiveUsers(), 'username', 'id'), new LabelAdditionalParams('Системные пользователи'), new SelectElementAdditionalParams(true)),
        );
        $this->appendElements(
            new SelectSearch('system_user_groups', ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id'), new LabelAdditionalParams('Системные группы'), new SelectElementAdditionalParams(true)),
        );
        $this->appendElements(
            new Button('Сохранить', 'submit', new FormElementAdditionalParams())
        );


        $this->getValidationBuilder()->getSetRules(
            [
                'system_users' => ['required'],
                'system_user_groups' => ['required'],
            ]
        );
    }
}

