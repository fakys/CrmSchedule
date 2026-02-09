@vite(App\Modules\Crm\lessons\assets\LessonsTabBundle::CssFiles())
<div>
    @csrf
    <div class="tabs-container">
        <div class="tabs-button" id="student_groups_info" data-url="{{route('lessons.get_lessons_info_tab')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация
            </div>
        </div>
        <div class="tabs-button" id="edit_student_groups_info" data-url="{{route('lessons.get_edit_lessons_info_tab')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Редактировать
            </div>
        </div>
    </div>
    <div class="tabs-content"></div>
</div>
@vite(App\Modules\Crm\lessons\assets\LessonsTabBundle::JsFiles())
