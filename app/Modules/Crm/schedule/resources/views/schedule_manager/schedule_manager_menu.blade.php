<div class="p-3">
    @csrf
    <div class="d-none link-add-schedule" data-url="{{route('schedule.add_schedule_manager_menu')}}"></div>
    <div class="d-none link-schedule" data-url="{{route('schedule.has_schedule_manager_menu')}}"></div>
    <div class="menu-container-data"></div>
</div>

{{$assetsBundleManager->registerFile('app/Modules/Crm/schedule/resources/js/schedule_manager_menu.js')}}
