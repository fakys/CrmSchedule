<?php

namespace App\Modules\Crm\lessons\controllers;

use App\Modules\Crm\lessons\models\LessonModel;
use App\Modules\Crm\lessons\models\AddNumberPairs;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

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

    public function actionLessons()
    {
        $lessons = BackendHelper::getRepositories()->getAllLessonsInfo();
        $title = 'Предметы преподавателя';
        return view('lessons::lessons.lessons_info', compact('lessons', 'title'));
    }

    public function setLesson()
    {
        $model = new LessonModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            if ($model->validateLesson()) {
                BackendHelper::getOperations()->addLesson($model);
            } else {
                $validate->errors()->add('teacher', 'Данная связь уже существует');
                return redirect()->back()
                    ->withErrors($validate)
                    ->withInput();
            }

        }
        return redirect()->route('lessons.lessons');
    }

    public function actionAddLesson()
    {
        $title = 'Добавить связь';
        $subjects = ArrayHelper::getColumn(BackendHelper::getRepositories()->getSubjectInfo(), 'name', 'id');
        $teachers = [];
        foreach (BackendHelper::getRepositories()->getAllTeachers() as $teacher) {
            $teachers[$teacher->id] = $teacher->getFio();
        }
        return view('lessons::lessons.add_lesson', compact('title', 'subjects', 'teachers'));
    }

    /**
     * Последовательность пар
     */
    public function actionNumberPair()
    {
        $pair_number = BackendHelper::getRepositories()->getNumberPair();
        return view('lessons::lessons.pair_number', [
            'pair_number' => $pair_number,
            'title' => 'Последовательность пар',
            'nav_subject' => true
        ]);
    }

    public function actionAddNumberPair()
    {
        return view('lessons::lessons.form_pair_number', [
            'title' => 'Добавить последовательность пар',
            'nav_subject' => true
        ]);
    }

    public function addNumberPair()
    {
        if (request()->isMethod('POST')) {
            $model = new AddNumberPairs();
            $model->load(request()->all());
            $validate = Validator::make($model->getData(), $model->rules());
            if ($validate->validate()) {
                BackendHelper::getRepositories()->addNumberPair($model->getData());
            }
        }
        return redirect()->route('lessons.pair_number');
    }

    public function actionUpdateNumberPair()
    {
        $id = request()->get('id');
        $number_pair = BackendHelper::getRepositories()->getNumberPairById($id);
        if (!$number_pair) {
            abort(404);
        }
        return view('lessons::lessons.form_pair_number', [
            'title' => 'Добавить последовательность пар',
            'number_pair' => $number_pair,
            'nav_subject' => true
        ]);
    }

    public function updateNumberPair()
    {
        if (request()->isMethod('POST')) {
            $id = request()->get('id');
            $model = new AddNumberPairs();
            $model->load(request()->all());
            $validate = Validator::make($model->getData(), $model->rules());
            if ($validate->validate()) {
                BackendHelper::getRepositories()->updateNumberPairById($model->getData(), $id);
            }
        }
        return redirect()->route('lessons.pair_number');
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
