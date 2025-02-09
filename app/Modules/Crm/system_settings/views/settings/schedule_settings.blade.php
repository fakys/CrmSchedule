@extends('layout::base_layout')

@section('style_files')

@endsection
@section('js_files')

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
                    <div>
                        <input type="submit" class="btn-main" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
