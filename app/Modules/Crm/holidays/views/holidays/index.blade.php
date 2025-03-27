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
        asdsad
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/modules/holidays/holidays.js')}}"></script>
@endsection
