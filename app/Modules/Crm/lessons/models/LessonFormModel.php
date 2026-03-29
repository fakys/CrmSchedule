<?php
namespace App\Modules\Crm\lessons\models;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\models\returnData\AddSubjectReturnData;
use App\Modules\Crm\lessons\models\returnData\LessonReturnData;
use App\Modules\Crm\system_settings\models\returnData\CrmSettingsReturnData;
use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
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

/**
 * @method LessonReturnData getReturnData()
 */
class LessonFormModel extends AbstractForm
{
    private $update_id;

    private $is_ajax = false;

    public function __construct(string $formTag, FormAdditionalParamInterface $additionalParam, $update_id = null, $is_ajax = false)
    {
        $this->update_id = $update_id;
        $this->is_ajax = $is_ajax;
        parent::__construct($formTag, $additionalParam);
    }

    public function isAjax()
    {
        return $this->is_ajax;
    }

    public function getAssets(): array
    {
        return [];
    }
    public function getAttribute(): array
    {
        return [
            'teacher' => 'Преподаватель',
            'subject' => 'Предмет'
        ];
    }

    public function returnData(): string
    {
        return LessonReturnData::class;
    }

    public function buildForm()
    {
        $teachers = [];
        foreach (BackendHelper::getRepositories()->getAllTeachers() as $teacher) {
            $teachers[$teacher->id] = $teacher->getFio();
        }
        $subjects = ArrayHelper::getColumn(BackendHelper::getRepositories()->getSubjectInfo(), 'name', 'id');

        $this->appendElements(
            new SelectSearch('teacher', $teachers, new LabelAdditionalParams('Преподаватель'), new SelectElementAdditionalParams()),
        );
        $this->appendElements(
            new SelectSearch('subject', $subjects, new LabelAdditionalParams('Предмет'), new SelectElementAdditionalParams()),
        );
        $this->appendElements(
            new Button($this->update_id ? 'Обновить' : 'Создать', 'submit', new FormElementAdditionalParams())
        );


        $this->getValidationBuilder()->getSetRules(
            [
                'teacher' => [
                    'required',
                    'exists:users,id',
                    function ($attribute, $value, $fail) {
                        $return_data = $this->getReturnData();
                        if (BackendHelper::getRepositories()->checkLessonByTeacherAndSubject($return_data->getTeacher(), $return_data->getSubject())) {
                            $fail('Данная связь уже существует');
                        }
                    },
                ],
                'subject' => [
                    'required',
                    'exists:subjects,id'
                ],
            ]
        );
    }
}

