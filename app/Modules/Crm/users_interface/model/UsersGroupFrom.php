<?php

namespace App\Modules\Crm\users_interface\model;

use App\Assets\LayoutBundle;
use App\Modules\Crm\users_interface\model\returnData\UsersGroupReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectDuallistbox;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use App\Src\BackendHelper;
use Illuminate\Validation\Rule;

/**
 * @method UsersGroupReturnData getReturnData()
 */
class UsersGroupFrom extends AbstractForm
{
    private $update_id;
    public function __construct($tag, $additionalParams, $update_id = null)
    {
        $this->update_id = $update_id;
        parent::__construct($tag, $additionalParams);
    }

    public function getAssets(): array
    {
        return [
            LayoutBundle::class,
        ];
    }

    public function getAttribute(): array
    {
        return [
            'name' => 'Название группы',
            'description' => 'Описание группы',
            'accesses' => 'Доступы'
        ];
    }

    public function returnData(): string
    {
        return UsersGroupReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'name', new LabelAdditionalParams('Название группы'), new FormElementAdditionalParams('', [], 'Название группы')),
        );

        $this->appendElements(
            new Textarea('description', new LabelAdditionalParams('Описание группы'), new FormElementAdditionalParams('', [], 'Описание группы')),
        );

        $this->appendElements(
            new SelectDuallistbox('accesses', BackendHelper::getOperations()->getAccessForForm(), new LabelAdditionalParams('Доступы'), new SelectElementAdditionalParams())
        );

        $this->appendElements(
            new Button($this->update_id ? 'Обновить' : 'Создать', 'submit', new FormElementAdditionalParams())
        );

        $this->getValidationBuilder()->getSetRules([
            'name' => ['required', $this->update_id ? Rule::unique('user_groups')->ignore($this->update_id) : Rule::unique('user_groups'), 'min:3', 'max:255', 'string'],
            'description' => ['nullable', 'min:3', 'string'],
            'accesses' => ['nullable'],
        ]);
    }
}

