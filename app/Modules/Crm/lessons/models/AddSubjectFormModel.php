<?php
namespace App\Modules\Crm\lessons\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\models\returnData\AddSubjectReturnData;
use App\Modules\Crm\system_settings\models\returnData\CrmSettingsReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;

/**
 * @method AddSubjectReturnData getReturnData()
 */
class AddSubjectFormModel extends AbstractForm
{
    public function getAssets(): array
    {
        return [
            LayoutBundle::class,
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
        return AddSubjectReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'name', new LabelAdditionalParams('Название'), new FormElementAdditionalParams('', [], 'Название')),
        );
        $this->appendElements(
            new Input('text', 'full_name', new LabelAdditionalParams('Полное название'), new FormElementAdditionalParams('', [], 'Полное название')),
        );
        $this->appendElements(
            new Textarea('description', new LabelAdditionalParams('Описание'), new FormElementAdditionalParams('', [], 'Описание')),
        );
        $this->appendElements(
            new Button('Создать', 'submit', new FormElementAdditionalParams())
        );


        $this->getValidationBuilder()->getSetRules(
            [
                'name' => ['required', 'unique:subjects', 'min:3', 'max:255'],
                'full_name' => ['required', 'unique:subjects', 'min:3', 'max:255'],
            ]
        );
    }
}

