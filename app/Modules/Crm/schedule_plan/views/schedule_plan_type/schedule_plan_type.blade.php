<div id="url_get_form" data-url="{{route('schedule_plan.form_add_type_schedule')}}"></div>
<div id="url_add_type_plan" data-url="{{route('schedule_plan.add_type_schedule')}}"></div>
<div id="url_delete_week_type_plan" data-url="{{route('schedule_plan.delete_week_type_schedule')}}"></div>
@if (isset($type))
    <div id="url_edit_type_plan" data-url="{{route('schedule_plan.edit_type_schedule')}}"></div>
    <div id="week_data" data-weeks="{{json_encode($type->getWeeks())}}" data-id="{{$type->id}}"></div>
@endif
<div class="container">
    <div class="card">
        <div class="card-header">
            Добавление типа плана расписания
        </div>
        <div class="card-body">
            <div class="p-3">
                <div>
                    <div class="form-group">
                        <label>Название типа</label>
                        <input class="form-control" type="text" placeholder="Введите название типа" id="type_name" @if(isset($type)) value="{{$type->name}}" @endif>
                    </div>
                    <div class="form-group">
                        <div class="p-3">
                            <div>Недели в плане</div>
                            <div id="add_week_form"></div>
                            <div class="d-flex justify-content-center"><div class="add_week_btn btn-main w-25 text-center">Добавить неделю</div></div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-center"><div class="btn-main save-type-week">Создать</div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/add_type_schedule_plan.js')}}"></script>
