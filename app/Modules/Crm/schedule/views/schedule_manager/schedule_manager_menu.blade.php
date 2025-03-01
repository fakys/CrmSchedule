<div class="p-3">
    <div class="d-none link-add-schedule" data-url="{{route('schedule.add_schedule_manager_menu')}}"></div>
    {{\App\Src\Html\Html::nav_tabs([
    ['name'=>'Расписание', 'id'=>'schedule', 'active'=>true],
    ['name'=>'Добавить расписание', 'id'=>'edit_schedule'],
    ['name'=>'Автоматическое составление расписания', 'id'=>'auto_create_schedule'],
    ['name'=>'Редактировать расписание', 'id'=>'edit_schedule']
])}}
    <div class="menu-container-data"></div>
</div>


<script src="{{asset('assets/js/schedule_manager_menu.js')}}"></script>
