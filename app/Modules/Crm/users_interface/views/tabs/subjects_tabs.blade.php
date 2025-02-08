<link rel="stylesheet" href="{{asset('assets/css/tabs.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/tabs/student_groups.css')}}">
<div>
    @csrf
    <div class="tabs-container">
        <div class="tabs-button" id="student_groups_info" data-url="{{route('users_interface.tabs.get_subject_info_tab')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация о предмете
            </div>
        </div>
        <div class="tabs-button" id="edit_student_groups_info" data-url="{{route('users_interface.tabs.action_edit_subject_info_tab')}}">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация о предмете
            </div>
        </div>
        <div class="tabs-button" id="student_groups_all_subjects" data-url="">
            <div class="tabs-btn-icon"><i class="fa fa-book" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Все часы предмета
            </div>
        </div>
    </div>
    <div class="tabs-content"></div>
</div>
<script src="{{asset('assets/js/tabs/tabs.js')}}"></script>
