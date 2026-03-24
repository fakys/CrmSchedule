<?php
namespace App\Modules\Crm\auth\models;

use App\Assets\BaseLayoutBundle;
use App\Modules\Crm\auth\models\formsReturnData\LoginFormReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Views\Infrastructure\Services\Elements\AdditionalParams\ViewElementAdditionalParams;
use App\Services\Views\Infrastructure\Services\Elements\DivElement;

class LoginFormModel extends AbstractForm
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
            'login',
            'password',
        ];
    }

    public function returnData(): string
    {
        return LoginFormReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'login', new LabelAdditionalParams('Логин'), new FormElementAdditionalParams()),
        );
        $this->appendElements(
            new Input('password', 'password', new LabelAdditionalParams('Пароль'), new FormElementAdditionalParams()),
        );
        $div = new DivElement(new ViewElementAdditionalParams('', ['d-flex', 'justify-content-center']));
        $div->appendElements(new Button('Войти', 'submit', new FormElementAdditionalParams()));
        $this->appendElements(
            $div
        );


        $this->getValidationBuilder()->getSetRules(
            [
                'login' => ['required', 'max:255', 'min:3', 'string'],
                'password' => ['required', 'string'],
            ]
        );
    }
}

