<?php
namespace App\Modules\Crm\schedule_plan\models;

use App\Modules\Crm\schedule_plan\models\returnData\PairFormReturnData;
use App\Modules\Crm\schedule_plan\src\CardEntity;
use App\Services\Forms\Domain\Services\AdditionalParams\FormAdditionalParamInterface;
use App\Services\Forms\Infrastructure\Services\AbstractForm;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\FormElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FromParams\SelectElementAdditionalParams;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\LabelAdditionalParams;
use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch;
use App\Services\Forms\Infrastructure\Services\FormElement\Textarea;
use App\Services\Forms\Infrastructure\Services\FormElement\TimePicker;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;

class PairForm extends AbstractForm
{
    private CardEntity $card;

    public function __construct(string $formTag, FormAdditionalParamInterface $additionalParam, CardEntity $card)
    {
        $this->card = $card;
        parent::__construct($formTag, $additionalParam);
    }

    public function getAttribute(): array
    {
        return [];
    }

    public function returnData(): string
    {
        return PairFormReturnData::class;
    }

    public function buildForm()
    {
        $users = [];
        $users_obj = BackendHelper::getRepositories()->getAllTeachers();
        foreach ($users_obj as $user) {
            $users[$user->id] = $user->getFio();
        }


        $users_select = new SelectSearch(
            'teacherId',
            $users, new LabelAdditionalParams('Преподаватель'),
            new SelectElementAdditionalParams(false, '', ['form-control', 'users_select', 'schedule-input']),
            $this->card->getTeacherId()
        );

        $this->appendElements($users_select);
        if ($this->card->getTeacherId()) {
            $subject = [];
            foreach (BackendHelper::getRepositories()->getLessonsByUser($this->card->getTeacherId()) as $lesson) {
                $sub = BackendHelper::getRepositories()->getSubjectById($lesson->subject_id);
                $subject[$sub->id] = $sub->name;
            }
            $subject_select = new SelectSearch(
                'subjectId',
                $subject,
                new LabelAdditionalParams('Предмет'),
                new SelectElementAdditionalParams(false, '', ['form-control', 'subject_select', 'schedule-input']),
                $this->card->getSubjectId()
            );

            $this->appendElements($subject_select);
        }
        $pair = BackendHelper::getRepositories()->getPairByNumber($this->card->getNumberPair());

        $time_start = new Input(
            'time',
            'timeStart',
            new LabelAdditionalParams('Время начала'),
            new FormElementAdditionalParams('', ['form-control', 'schedule-input']),
            $this->card->getTimeStart() ?? $pair->time_start
        );
        $this->appendElements($time_start);

        $time_end = new Input(
            'time',
            'timeEnd',
            new LabelAdditionalParams('Время окончания'),
            new FormElementAdditionalParams('', ['form-control', 'schedule-input']),
            $this->card->getTimeEnd() ?? $pair->time_end
        );
        $this->appendElements($time_end);

        $formats = ArrayHelper::getColumn(BackendHelper::getRepositories()->getFullFormatLessons(), 'name', 'id');
        $format_select = new SelectSearch(
            'formatId',
            $formats,
            new LabelAdditionalParams('Формат пары'),
            new SelectElementAdditionalParams(false, '', ['form-control', 'schedule-input']),
            $this->card->getFormatId()??1 /** todo Сделать настройку */
        );
        $this->appendElements($format_select);


        $description = new Textarea(
            'description',
            new LabelAdditionalParams('Описание'),
            new FormElementAdditionalParams('', ['form-control', 'schedule-input']),
            $this->card->getDescription()
        );
        $this->appendElements($description);
    }
}
