@extends('layout::base_layout')

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
            ['name'=>'Статус модулей', 'url'=>route('modules_settings.settings')],
            ['name'=>'Добавить модуль', 'url'=>route('modules_settings.add_module'), 'active'=>true]
        ])}}
        <div class="card">
            <form class="card-body" method="post" enctype="multipart/form-data" action="{{route('modules_settings.save_modules')}}">
                @csrf
                {{\App\Src\Html\Html::select_search('Модули', 'modules', $full_modules)}}
                {{\App\Src\Html\Html::checkbox_2('active_modules', 'Активные модули')}}
                <div class="form-group">
                    <input type="submit" class="btn-main" value="Добавить">
                </div>
            </form>
        </div>
    </div>
@endsection
