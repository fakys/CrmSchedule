<div id="url_edit_lesson" data-url="{{route('lessons.edit_lessons_info')}}"></div>

<div class="container">
    {{\App\Src\Html\Html::select_search('Преподаватель', 'teacher', $teachers, [$lesson->user_id], '', false)}}
    {{\App\Src\Html\Html::select_search('Предмет', 'subject', $subjects, [$lesson->subject_id], '', false)}}
    <div><button class="btn-main" id="bnt_save">Сохранить</button></div>
</div>

@vite(App\Modules\Crm\lessons\assets\EditInfoLessonsBundle::JsFiles())
