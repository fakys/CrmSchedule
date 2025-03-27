@extends('layout::base_layout')
@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/css/holidays.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/litepicker.css')}}">
    <script src="{{asset('assets/plugins/js/litepicker.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
        ['name'=>'Общие настройки', 'url'=>route('holidays.settings'), 'active'=>true],
        ['name'=>'Настройки на семестры', 'url'=>'#']
    ])}}
        <div class="bg-white p-3 container">
            <div id="holiday_form" data-url="{{route('holidays.holiday_form')}}"></div>
            <div id="holiday_save" data-url="{{route('holidays.set_holiday_form')}}"></div>
            @csrf
            <h4 class="mb-3">Общие настройки праздничных дней</h4>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">{{App\Src\Html\Html::checkbox('use_settings', 'Использовать общие настройки', isset($setting['use_settings'])?$setting['use_settings']:false)}}</div>
                    <div class="card form-group" id="holidays_container">
                        <div class="card-header">
                            Праздничныe дни
                        </div>
                        <div class="card-body">
                            <div id="holidays_container_data"></div>
                            <div class="d-flex justify-content-center"><div class="btn-main" id="add_holiday_btn">Добавить праздничный день</div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex"><div class="btn-main" id="btn_save">Сохранить</div></div>
        </div>
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/modules/holidays/holidays.js')}}"></script>
@endsection
