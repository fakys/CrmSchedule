<?php

namespace App\Modules\Crm\users_interface\model;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\returnData\SpecialtyReturnData;
use App\Modules\Crm\users_interface\assets\AddUserBundle;
use App\Modules\Crm\users_interface\model\returnData\UserBaseInfoReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectDuallistbox;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Validation\Rule;

/**
 * @method UserBaseInfoReturnData getReturnData()
 */
class UserBaseInfoFrom extends AbstractForm
{

    public function getAssets(): array
    {
        return [
            AddUserBundle::class,
        ];
    }

    public function getAttribute(): array
    {
        return [
            'username' => 'Логин пользователя',
            'fio' => 'Фио пользователя',
            'password' => 'Пароль пользователя',
            'groups' => 'Группы пользователя'
        ];
    }

    public function returnData(): string
    {
        return UserBaseInfoReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'username', new LabelAdditionalParams('Логин пользователя'), new FormElementAdditionalParams('', [], 'Логин пользователя')),
        );
        $this->appendElements(
            new Input('text', 'fio', new LabelAdditionalParams('Фио пользователя'), new FormElementAdditionalParams('', [], 'Фио пользователя')),
        );

        $this->appendElements(
            new Input('password', 'password', new LabelAdditionalParams('Пароль пользователя'), new FormElementAdditionalParams('', [], 'Пароль пользователя')),
        );

        $this->appendElements(
            new SelectDuallistbox('groups', ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllUsersGroup(), 'name', 'id'), new LabelAdditionalParams('Группы пользователя'), new SelectElementAdditionalParams()),
        );

        $this->appendElements(
            new Button('Создать', 'submit', new FormElementAdditionalParams())
        );

        $rules = [
            'username' => ['required', Rule::unique('users'), 'min:3', 'max:255', 'string'],
            'fio' => ['required', 'min:3', 'max:255', 'string'],
            'password' => ['required', 'min:6', 'max:255', 'string'],
            'groups' => ['required', Rule::exists('user_groups', 'id')],
        ];

        $this->getValidationBuilder()->getSetRules($rules);
    }
}

