@extends('layout::base_layout')

@section('style_files')

@endsection
@section('js_files')
<script src="{{asset('assets/js/schedule_settings.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
            ['name'=>'Настройки CRM', 'url'=>route('system_settings.crm_settings')],
            ['name'=>'Настройки системы', 'url'=>route('system_settings.settings')],
            ['name'=>'Настройки расписания', 'url'=>route('system_settings.schedule_settings'), 'active'=>true]
        ])}}
        <div class="card">
            <div class="card-body">
                <form method="post" class="form" action="{{route('system_settings.set_schedule_settings')}}">
                    @csrf
                    {{
                    App\Src\Html\Html::select_duallistbox_multiple('Группы преподавателей', 'users_groups[]',
                    \App\Src\helpers\ArrayHelper::getColumn($users_groups, 'name', 'id'),
                    $users_groups_settings,
                    'users-group-select')
                    }}
                    <div class="form-group">
                        <label>Тип по которому будет отображаться расписание</label>
                        <select name="type_weeks" class="form-control" title="Данная настройка влияет только на отображение расписания">
                            @foreach($type_weeks as $type=>$name)
                                @if($settings->type_weeks)
                                    @if($type==$settings->type_weeks)
                                        <option value="{{$type}}" selected>{{$name}}</option>
                                    @else
                                        <option value="{{$type}}">{{$name}}</option>
                                    @endif
                                @else
                                    <option value="{{$type}}" selected>{{$name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center gap-3">
                            <label for="cash_schedule">Кешировать расписание</label>
                            <input type="checkbox" id="cash_schedule" name="cash_schedule" @if($settings->cash_schedule) checked @endif>
                            <div class="description-settings" title="Кеширование расписания значительно ускорит работу системы"><i class="fa fa-question" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    <div class="form-group d-none" id="cash_container">
                        <div class="d-flex align-items-center gap-3">
                            <label for="cash_schedule">как часто кешировать расписание? (В минутах)</label>
                            <input type="number" id="cash_schedule" name="count_minutes_for_cash" min="5" value="{{$settings->count_minutes_for_cash}}">
                        </div>
                    </div>
                    <div>
                        <input type="submit" class="btn-main" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
