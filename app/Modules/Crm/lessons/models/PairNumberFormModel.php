<?php

namespace App\Modules\Crm\lessons\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\models\returnData\AddSubjectReturnData;
use App\Modules\Crm\lessons\models\returnData\PairNumberReturnData;
use App\Modules\Crm\system_settings\models\returnData\CrmSettingsReturnData;
use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use Illuminate\Validation\Rule;

/**
 * @method AddSubjectReturnData getReturnData()
 */
class PairNumberFormModel extends AbstractForm
{
    private $update_id;

    public function __construct(string $formTag, FormAdditionalParamInterface $additionalParam, $update_id = null)
    {
        $this->update_id = $update_id;
        parent::__construct($formTag, $additionalParam);
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
            'number',
            'name',
        ];
    }

    public function returnData(): string
    {
        return PairNumberReturnData::class;
    }

    public function buildForm()
    {
        $this->appendElements(
            new Input('text', 'name', new LabelAdditionalParams('Название'), new FormElementAdditionalParams('', [], 'Название')),
        );
        $this->appendElements(
            new Input('number', 'number', new LabelAdditionalParams('Номер'), new FormElementAdditionalParams('', [], 'Номер')),
        );
        $this->appendElements(
            new Button($this->update_id ? 'Обновить' : 'Создать', 'submit', new FormElementAdditionalParams())
        );

        $rules = [
            'number' => ['required', $this->update_id ? Rule::unique('pair_numbers')->ignore($this->update_id) : Rule::unique('pair_numbers'), 'min:0', 'max:10'],
            'name' => ['required', $this->update_id ? Rule::unique('pair_numbers')->ignore($this->update_id) : Rule::unique('pair_numbers'), 'min:3', 'max:255', 'string'],
        ];

        $this->getValidationBuilder()->getSetRules($rules);
    }
}

