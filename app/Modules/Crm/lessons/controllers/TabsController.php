<?php
namespace App\Modules\Crm\lessons\controllers;

use App\Modules\Crm\lessons\models\LessonModel;
use App\Src\BackendHelper;
use App\Src\helpers\ArrayHelper;
use Illuminate\Routing\Controller;
use App\Src\modules\controllers\AbstractController;
use Illuminate\Support\Facades\Validator;

class TabsController extends Controller
{
    public function getTabsByLesson()
    {
        return view('lessons.tabs.get_tabs');
    }

    public function getLessonsInfoTab()
    {
        $lesson = BackendHelper::getRepositories()->getAllLessonsInfoById(
            request()->post('id')
        );

        return view('lessons.tabs.lessons_info_tab', compact('lesson'));
    }

    public function getEditLessonsInfoTab()
    {
        $lesson = BackendHelper::getRepositories()->getLessonsById(
            request()->post('id')
        );
        $subjects = ArrayHelper::getColumn(BackendHelper::getRepositories()->getSubjectInfo(), 'name', 'id');
        $teachers = [];
        foreach (BackendHelper::getRepositories()->getAllTeachers() as $teacher) {
            $teachers[$teacher->id] = $teacher->getFio();
        }
        return view('lessons.tabs.edit_lessons_info_tab', compact('subjects', 'teachers', 'lesson'));
    }

    public function editLessonsInfo()
    {
        $lesson = BackendHelper::getRepositories()->getLessonsById(
            request()->post('id')
        );
        $model = new LessonModel();
        $model->load(request()->post());
        $validate = Validator::make($model->getData(), $model->rules());
        if ($validate->validate()) {
            if ($model->validateLesson()) {
                $lesson->user_id = $model->teacher;
                $lesson->subject_id = $model->subject;
                BackendHelper::getRepositories()->setLesson($lesson);
            } else {
                $validate->errors()->add('teacher', 'Данная связь уже существует');
                return response()->json([
                    'message' => 'Данная связь уже существует',
                    'errors' => $validate->errors()
                ], 422);
            }
        }

    }
}
