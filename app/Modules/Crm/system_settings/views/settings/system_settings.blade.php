@extends('layout::base_layout')

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
            ['name'=>'Настройки CRM', 'url'=>route('system_settings.crm_settings')],
            ['name'=>'Настройки системы', 'url'=>route('system_settings.settings'), 'active'=>true]
        ])}}
        <div class="card">
            <div class="card-body">
                <form method="post" class="form" action="{{route('system_settings.set_system_settings')}}">
                    @csrf
                    <div>
                        {{\App\Src\Html\Html::select_search('Системные пользователи', 'system_users', $users)}}
                    </div>
                    <div>
                        {{\App\Src\Html\Html::select_search('Системные группы', 'system_user_groups', $groups)}}
                    </div>
                    <div>
                        <input type="submit" class="btn-main" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
