@extends("layout::base_layout")


@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/css/schedule_plan.css')}}">
@endsection

@section('content')
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="title-schedule-plan">Редактор плана расписания</div>
            </div>
            <div class="card-body">
                <div>
                    <div class="form-group">
                        <label>Семестр</label>
                        <select class="semester-select form-control" name="semester">
                            <option>Нет данных</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Группа</label>
                        <select class="semester-select form-control" name="semester">
                            <option>Нет данных</option>
                        </select>
                    </div>
                </div>
                <div><div class="btn btn-main">Найти</div><a href="{{route('schedule_plan.add_schedule_plan')}}" class="btn btn-main ml-4">Добавить новое</a></div>
            </div>
        </div>
    </div>
@endsection
