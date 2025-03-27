@extends('layout::base_layout')
@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/litepicker.css')}}">
    <script src="{{asset('assets/plugins/js/litepicker.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/holidays.css')}}">
@endsection

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
        ['name'=>'Общие настройки', 'url'=>route('holidays.settings'), 'active'=>true],
        ['name'=>'Настройки по дате', 'url'=>route('holidays.holidays')]
    ])}}
        <div class="bg-white p-3 container">
            <div id="holiday_form" data-url="{{route('holidays.holiday_form')}}"></div>
            <div id="holiday_save" data-url="{{route('holidays.set_holiday_form')}}"></div>
            @csrf
            <h4 class="mb-3">Общие настройки праздничных дней</h4>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">{{App\Src\Html\Html::checkbox('use_settings', 'Использовать общие настройки', isset($setting['use_settings'])?$setting['use_settings']:false)}}</div>
                    <div class="form-group">
                        <div class="d-flex align-items-center gap-3">
                            <label class="m-0" for="use_priority_setting">Выбирать приоритетные праздники</label>
                            <input type="checkbox" class="form-control-sm" id="use_priority_setting" name="use_priority_setting" @if(isset($setting['use_priority_setting']) && $setting['use_priority_setting'] == 'true') checked @endif>
                            <div class="description-settings" title="Если праздники наслаиваются друг на друга, выбирать приоритетные"><i class="fa fa-question" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    <div class="form-group" id="priority_setting_container">
                        <label class="m-0">Приоритет настроек</label>
                        <select class="form-control" id="priority_setting" name="priority_setting">
                            <option value="1" @if(isset($setting['priority_setting']) && $setting['priority_setting'] == 1) selected @endif>Общие настройки</option>
                            <option value="2" @if(isset($setting['priority_setting']) && $setting['priority_setting'] == 2) selected @endif>Настройки по датам</option>
                        </select>
                    </div>
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
    <script src="{{asset('assets/modules/holidays/holidays_setting.js')}}"></script>
@endsection
