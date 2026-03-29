<div class="p-3">
    @csrf
    <div class="d-none link-add-schedule" data-url="{{route('schedule.add_schedule_manager_menu')}}"></div>
    <div class="d-none link-schedule" data-url="{{route('schedule.has_schedule_manager_menu')}}"></div>
    <div class="main-nav-tabs">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <div class="nav-link nav-tabs-link active" id="schedule">Расписание</div>
            </li>
            <li class="nav-item">
                <div class="nav-link nav-tabs-link" id="edit_schedule">Редактировать расписание</div>
            </li>
        </ul>
    </div>
    <div class="menu-container-data"></div>
</div>

{{$assetsBundleManager->registerFile('app/Modules/Crm/schedule/resources/js/schedule_manager_menu.js')}}
