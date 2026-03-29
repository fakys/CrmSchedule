<?php

namespace App\Modules\Crm\lessons\controllers;

use App\Assets\LayoutBundle;
use App\Modules\Crm\lessons\assets\PairNumberBundle;
use App\Modules\Crm\lessons\models\AddNumberPairs;
use App\Modules\Crm\lessons\models\LessonFormModel;
use App\Modules\Crm\lessons\models\LessonsTable;
use App\Modules\Crm\lessons\models\PairNumberFormModel;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\modules\controllers\AbstractController;

class LessonsController extends AbstractController
{

    public static function loadController(\App\Src\modules\kernel\KernelModules $kernel)
    {
        $kernel->getControllerLoader()
            ->RmGroup('rm_administrator')
            ->RmGroupList('operations')
            ->RmLink('add_number_pair_operation')
            ->setText('Последовательность пар')
            ->setLink(route('lessons.pair_number'));

        $kernel->getControllerLoader()
            ->RmGroup('rm_teachers')
            ->RmGroupList('subjects_list')
            ->RmLink('lessons')
            ->setText('Пары преподавателей')
            ->setLink(route('lessons.lessons'));

    }

    static function assets(): array
    {
        return [
            LayoutBundle::class
        ];
    }

    public function actionLessons()
    {
        $lessons = BackendHelper::getRepositories()->getAllLessonsInfo();
        $table = new LessonsTable('table', $lessons, route('lessons.get_tabs'));
        ViewManager::appendElement($table);
        $title = 'Предметы преподавателя';
        return view('lessons::lessons.lessons_info', compact('title'));
    }

    public function actionAddLesson()
    {
        $title = 'Добавить связь';
        $form = new LessonFormModel(
            'form',
            new FormAdditionalParam(
                'post',
                route('lessons.add_lesson')
            ),
            request()->get('id')
        );

        if (request()->isMethod('POST')) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();
            BackendHelper::getRepositories()->createLessons($return_data->getSubject(), $return_data->getTeacher());
            return redirect()
                ->route('lessons.add_lesson')
                ->with(['successMessage' => 'Связь успешно создана']);
        }

        ViewManager::appendElement($form);

        return view('lessons::lessons.add_lesson', compact('title'));
    }

    /**
     * Последовательность пар
     */
    public function actionNumberPair(AssetsBundleManagerInterface $assetsBundleManager)
    {
        $assetsBundleManager->appendBundle(new PairNumberBundle());

        $pair_number = BackendHelper::getRepositories()->getNumberPair();
        return view('lessons::lessons.pair_number', [
            'pair_number' => $pair_number,
            'title' => 'Последовательность пар',
            'nav_subject' => true
        ]);
    }

    public function actionAddNumberPair()
    {
        $form = new PairNumberFormModel('form_pair', new FormAdditionalParam('POST', route('lessons.action_add_pair_number')));

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();

            BackendHelper::getRepositories()->addNumberPair($return_data->toArray());
            return redirect()->route('lessons.pair_number');
        }

        ViewManager::appendElement($form);

        return view('lessons::lessons.form_pair_number', [
            'title' => 'Добавить последовательность пар'
        ]);
    }

    public function actionUpdateNumberPair()
    {
        $id = request()->get('id');
        $number_pair = BackendHelper::getRepositories()->getNumberPairById($id);
        if (!$number_pair) {
            abort(404);
        }

        $form = new PairNumberFormModel(
            'form_pair',
            new FormAdditionalParam('POST', route('lessons.action_update_pair_number', ['id' => $id])),
            $id
        );
        $form->load($number_pair->toArray());

        if (request()->post()) {
            $form->load(request()->post());
            $form->getValidationBuilder()->validate();
            $return_data = $form->getReturnData();
            BackendHelper::getRepositories()->updateNumberPairById($return_data->toArray(), $id);
            return redirect()->route('lessons.pair_number');
        }

        ViewManager::appendElement($form);

        return view('lessons::lessons.form_pair_number', [
            'title' => 'Добавить последовательность пар',
            'number_pair' => $number_pair,
            'nav_subject' => true
        ]);
    }

    public function deleteNumberPaid()
    {
        if (request()->isMethod('POST')) {
            $id = request()->post('pair_id');
            return BackendHelper::getRepositories()->deleteNumberPairById($id);
        }
        return false;
    }
}
