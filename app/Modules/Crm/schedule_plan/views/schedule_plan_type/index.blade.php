@extends("layout::base_layout")

@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/css/schedule_plan.css')}}">
@endsection

@section('js_files')
    <script src="{{asset('assets/js/type_plan_schedule.js')}}"></script>
@endsection

@section('content')
    @csrf
    <div id="url_search_operation" data-url="{{route('schedule_plan.operation_schedule_plan_types')}}"></div>
    <div class="container">
        <div class="card">
            <div class="card-header">Настройка типов плана расписания</div>
            <div class="card-body">
                <div class="plan-schedule-type-container">
                    <div class="plan-schedule-type">
                        <select class="form-control-sm" id="select_operation_plan_schedule">
                            <option value="add_schedule_plan_type">Добавить тип плана расписания</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center pt-2"><div class="btn-main" id="btn_search_type_plan">Найти</div></div>
                </div>
                <div id="operation_container"></div>
            </div>
        </div>
    </div>
@endsection
