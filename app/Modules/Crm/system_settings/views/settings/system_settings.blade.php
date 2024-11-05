@extends('layout::base_layout')

@section('style_files')

@endsection
@section('js_files')

@endsection

@section('content')
<div class="container">
    <form method="post" class="form">
        <div class="form-group">
            {{\App\Src\Html\Html::miniSelect('site_tome_zone', 'Часовой пояс системы', $allTimezones)}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::miniSelect('db_tome_zone', 'Часовой пояс базы данных', $allTimezones)}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::textInput('system_name', 'Название системы', $systemName)}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::baseSelect('system_lang', 'Язык системы', $systemLang)}}
        </div>
        <div class="form-group">
            {{\App\Src\Html\Html::checkbox('use_cash', 'Использовать кэширование', 1)}}
        </div>
    </form>
</div>
@endsection
