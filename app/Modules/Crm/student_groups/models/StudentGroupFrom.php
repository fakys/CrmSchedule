<?php

namespace App\Modules\Crm\student_groups\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\student_groups\models\returnData\SpecialtyReturnData;
use App\Modules\Crm\student_groups\models\returnData\StudentGroupReturnData;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Validation\Rule;

/**
 * @method StudentGroupReturnData getReturnData()
 */
class StudentGroupFrom extends AbstractForm
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
            'number' => 'Номер группы',
            'name' => 'Название группы',
            'specialty' => 'Специальность группы'
        ];
    }

    public function returnData(): string
    {
        return StudentGroupReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'name', new LabelAdditionalParams('Название группы'), new FormElementAdditionalParams('', [], 'Название группы')),
        );
        $this->appendElements(
            new Input('text', 'number', new LabelAdditionalParams('Номер группы'), new FormElementAdditionalParams('', [], 'Номер группы')),
        );

        $this->appendElements(
            new SelectSearch('specialty', ArrayHelper::getColumn(BackendHelper::getRepositories()->getAllSpecialties(), 'name', 'id'), new LabelAdditionalParams('Специальность группы'), new SelectElementAdditionalParams()),
        );

        $this->appendElements(
            new Button('Создать', 'submit', new FormElementAdditionalParams())
        );

        $rules = [
            'number' => ['required', Rule::unique('student_groups'), 'min:3', 'max:255', 'string'],
            'name' => ['required', Rule::unique('student_groups'), 'min:3', 'max:255', 'string'],
            'specialty' => ['required', Rule::exists('specialties', 'id')],
        ];

        $this->getValidationBuilder()->getSetRules($rules);
    }
}

