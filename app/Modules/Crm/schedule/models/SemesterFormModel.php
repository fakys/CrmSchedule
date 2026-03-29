<?php
namespace App\Modules\Crm\schedule\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\models\returnData\AddSubjectReturnData;
use App\Modules\Crm\lessons\models\returnData\LessonReturnData;
use App\Modules\Crm\schedule\models\returnData\SemesterReturnData;
use App\Modules\Crm\system_settings\models\returnData\CrmSettingsReturnData;
use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Button;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use Illuminate\Validation\Rule;

/**
 * @method SemesterReturnData getReturnData()
 */
class SemesterFormModel extends AbstractForm
{
    private $update_id;

    public function __construct(string $formTag, FormAdditionalParamInterface $additionalParam, $update_id = null)
    {
        $this->update_id = $update_id;
        parent::__construct($formTag, $additionalParam);
    }

    public function getAssets(): array
    {
        return [];
    }
    public function getAttribute(): array
    {
        return [
            'name' => 'Название семестра',
            'date_start' => 'Дата начала семестра',
            'date_end' => 'Дата окончания семестра',
            'year_start' => 'Начала учебного года',
            'year_end' => 'Окончание учебного года',
        ];
    }

    public function returnData(): string
    {
        return SemesterReturnData::class;
    }

    public function buildForm()
    {

        $this->appendElements(new Input('text', 'name', new LabelAdditionalParams('Название семестра'), new FormElementAdditionalParams()));
        $this->appendElements(new Input('date', 'date_start', new LabelAdditionalParams('Дата начала семестра'), new FormElementAdditionalParams()));
        $this->appendElements(new Input('date', 'date_end', new LabelAdditionalParams('Дата окончания семестра'), new FormElementAdditionalParams()));
        $this->appendElements(new Input('number', 'year_start', new LabelAdditionalParams('Начала учебного года'), new FormElementAdditionalParams()));
        $this->appendElements(new Input('number', 'year_end', new LabelAdditionalParams('Окончание учебного года'), new FormElementAdditionalParams()));

        $this->appendElements(
            new Button($this->update_id ? 'Обновить' : 'Создать', 'submit', new FormElementAdditionalParams())
        );

        $this->getValidationBuilder()->getSetRules(
            [
                'name' => ['required', Rule::unique('semesters')->ignore($this->update_id), 'string', 'min:3', 'max:255'],
                'date_start' => ['required', 'date', 'before:date_end'],
                'date_end' => ['required', 'date', 'after:date_start'],
                'year_start' => ['required', 'numeric', 'min:2000', 'max:3000'],
                'year_end' => ['required', 'numeric', 'min:2000', 'max:3000'],
            ]
        );
    }
}

