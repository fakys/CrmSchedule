<?php

namespace App\Modules\Crm\lessons\controllers;

use App\Modules\Crm\lessons\assets\LessonTabsBundle;
use App\Modules\Crm\lessons\models\LessonFormModel;
use App\Modules\Crm\lessons\models\LessonModel;
use App\Services\Abstracts\Domain\Facades\ViewManager;
use App\Services\AssetsBundle\Domain\Facades\AssetBundleManager;
use App\Services\Forms\Infrastructure\Services\AdditionalParams\FormAdditionalParam;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TabsController extends Controller
{
    public function getTabsByLesson()
    {
        AssetBundleManager::appendBundle(new LessonTabsBundle());
        return view('lessons::lessons.tabs.get_tabs');
    }

    public function getLessonsInfoTab()
    {
        $lesson = BackendHelper::getRepositories()->getAllLessonsInfoById(
            request()->post('id')
        );

        return view('lessons::lessons.tabs.lessons_info_tab', compact('lesson'));
    }

    public function getEditLessonsInfoTab()
    {
        $lesson = BackendHelper::getRepositories()->getLessonsById(
            request()->post('id')
        );
        $form = new LessonFormModel('form', new FormAdditionalParam('post', route('lessons.edit_lessons_info', ['id' => $lesson->id])));
        ViewManager::appendElement($form);
        $form->load([
            'teacher' => $lesson->user_id,
            'subject' => $lesson->subject_id,
        ]);

        return view('lessons::lessons.tabs.edit_lessons_info_tab', compact('lesson'));
    }

    public function editLessonsInfo()
    {
        $lesson = BackendHelper::getRepositories()->getLessonsById(
            request()->get('id')
        );
        $form = new LessonFormModel('form', new FormAdditionalParam('post', route('lessons.edit_lessons_info', ['id' => $lesson->id])));
        $form->load(request()->post());
        $validate = $form->getValidationBuilder();
        if ($validate->validate()) {
            $return_data = $form->getReturnData();
            if (!BackendHelper::getRepositories()->checkLessonByTeacherAndSubject($return_data->getTeacher(), $return_data->getSubject())) {
                $lesson->user_id = $return_data->getTeacher();
                $lesson->subject_id = $return_data->getSubject();
                BackendHelper::getRepositories()->setLesson($lesson);
            } else {
                return response()->json([
                    'message' => 'Данная связь уже существует',
                    'errors' => []
                ], 422);
            }
        }

    }
}
