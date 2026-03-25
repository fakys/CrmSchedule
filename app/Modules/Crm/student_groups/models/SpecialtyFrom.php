<?php

namespace App\Modules\Crm\student_groups\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\returnData\SpecialtyReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use Illuminate\Validation\Rule;

/**
 * @method SpecialtyReturnData getReturnData()
 */
class SpecialtyFrom extends AbstractForm
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
            'number' => 'Номер специальности',
            'name' => 'Название специальности',
            'description' => 'Описание специальности'
        ];
    }

    public function returnData(): string
    {
        return SpecialtyReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'name', new LabelAdditionalParams('Название специальности'), new FormElementAdditionalParams('', [], 'Название специальности')),
        );
        $this->appendElements(
            new Input('text', 'number', new LabelAdditionalParams('Номер специальности'), new FormElementAdditionalParams('', [], 'Номер специальности')),
        );

        $this->appendElements(
            new Textarea( 'description', new LabelAdditionalParams('Описание специальности'), new FormElementAdditionalParams('', [])),
        );

        $this->appendElements(
            new Button('Создать', 'submit', new FormElementAdditionalParams())
        );

        $rules = [
            'number' => ['required', Rule::unique('specialties'), 'min:3', 'max:255', 'string'],
            'name' => ['required', Rule::unique('specialties'), 'min:3', 'max:255', 'string'],
        ];

        $this->getValidationBuilder()->getSetRules($rules);
    }
}

