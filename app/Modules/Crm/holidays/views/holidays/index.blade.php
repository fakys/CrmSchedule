@extends('layout::base_layout')
@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/litepicker.css')}}">
    <script src="{{asset('assets/plugins/js/litepicker.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/holidays.css')}}">
@endsection

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
        ['name'=>'Общие настройки', 'url'=>route('holidays.settings')],
        ['name'=>'Настройки по дате', 'url'=>route('holidays.holidays'), 'active'=>true]
    ])}}
        <div class="p-3 bg-white container">
            <h4 class="mb-3">Настройки праздничных дней по датам</h4>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex"><a href="{{route('holidays.add_action_holiday')}}" class="btn-main ml-auto">Добавить</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/modules/holidays/holidays.js')}}"></script>
@endsection
