{{$assetsBundleManager->registerHeaderFiles()}}
<div class="container">
    {{$viewManager->renderElementByTag('form')}}
{{--    {{\App\Src\Html\Html::select_search('Преподаватель', 'teacher', $teachers, [$lesson->user_id], '', false)}}--}}
{{--    {{\App\Src\Html\Html::select_search('Предмет', 'subject', $subjects, [$lesson->subject_id], '', false)}}--}}
{{--    <div><button class="btn-main" id="bnt_save">Сохранить</button></div>--}}
</div>
{{$assetsBundleManager->registerBodyFiles()}}
{{$assetsBundleManager->registerFile('app/Modules/Crm/lessons/resources/js/edit_lessons_info.js')}}
