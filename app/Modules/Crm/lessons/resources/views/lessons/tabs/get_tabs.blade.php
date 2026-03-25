<link rel="stylesheet" href="{{asset('assets/css/tabs.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/tabs/student_groups.css')}}">
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
<script src="{{asset('assets/js/tabs/tabs.js')}}"></script>
