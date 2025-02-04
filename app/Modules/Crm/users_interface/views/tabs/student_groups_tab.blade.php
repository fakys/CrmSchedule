<link rel="stylesheet" href="{{asset('assets/css/tabs.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/tabs/student_groups.css')}}">
<div>
    @csrf
    <div class="tabs-container">
        <div class="tabs-button" id="student_groups_info" data-url="{{route('users_interface.tabs.get_tab_full_info_student_groups')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация о группе и специальности
            </div>
        </div>
        <div class="tabs-button" id="edit_student_groups_info" data-url="{{route('users_interface.tabs.edit_tab_full_info_student_groups')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация о группе и специальности
            </div>
        </div>
        <div class="tabs-button" id="student_groups_schedule" data-url="{{route('users_interface.tabs.user_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Расписание группы
            </div>
        </div>
        <div class="tabs-button" id="edit_student_groups_schedule" data-url="{{route('users_interface.tabs.user_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Расписание группы
            </div>
        </div>
        <div class="tabs-button" id="student_groups_all_subjects" data-url="{{route('users_interface.tabs.get_access_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-book" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Все предметы(с часами)
            </div>
        </div>
    </div>
    <div class="tabs-content"></div>
</div>
<script src="{{asset('assets/js/tabs/tabs.js')}}"></script>
