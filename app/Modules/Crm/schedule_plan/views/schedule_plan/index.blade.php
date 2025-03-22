@extends("layout::base_layout")


@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/css/schedule_plan.css')}}">
@endsection

@section('js_files')
    <script src="{{asset('assets/js/add_schedule_plan.js')}}"></script>
@endsection

@section('content')
    @csrf
    <div class="container">
        <div id="add_schedule_plan" data-url="{{route('schedule_plan.add_schedule_plan_form')}}"></div>
        <div id="check_schedule_plan" data-url="{{route('schedule_plan.check_schedule_plan')}}"></div>
        <div id="get_type_schedule_plan_form" data-url="{{route('schedule_plan.get_type_schedule_plan_form')}}"></div>
        <div class="card">
            <div class="card-header">
                <div class="title-schedule-plan">Добавить плана расписания</div>
            </div>
            <div class="card-body">
                <div>
                    <div class="form-group">
                        <label>Семестр</label>
                        <select class="semester-select form-control" name="semester" id="select_semester_schedule_plan">
                            @foreach($semesters as $semester)
                                <option value="{{$semester->id}}">{{$semester->name}} {{$semester->year_start}}-{{$semester->year_end}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Группа</label>
                        <select class="semester-select form-control" name="group" id="select_group_schedule_plan">
                            @foreach($groups as $group)
                                <option value="{{$group->id}}">{{$group->number}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="schedule_plan_type">

                    </div>
                </div>
                <div><div class="btn btn-main" id="add_plan_schedule">Добавить</div></div>
                <div class="pt-5">
                    <div id="add_plan_schedule_container"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
