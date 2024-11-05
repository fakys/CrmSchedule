@extends('layout::base_layout')

@section('style_files')

@endsection
@section('js_files')

@endsection

@section('content')
<div class="container">
    <form method="post" class="form" action="{{route('system_settings.set-settings')}}">
        @csrf
        <div class="form-group">
            {{\App\Src\Html\Html::miniSelect('site_tome_zone', 'Часовой пояс системы', $allTimezones, isset($setting)?$setting->site_tome_zone:'')}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::miniSelect('db_tome_zone', 'Часовой пояс базы данных', $allTimezones, isset($setting)?$setting->db_tome_zone:'')}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::textInput('system_name', 'Название системы', $systemName)}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::baseSelect('system_lang', 'Язык системы', $systemLang, isset($setting)?$setting->system_lang:'')}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::checkbox('use_cash', 'Использовать кэширование', isset($setting)?$setting->use_cash:'')}}
        </div>
        <div>
            <input type="submit" class="btn-main" value="Сохранить">
        </div>
    </form>
</div>
@endsection
