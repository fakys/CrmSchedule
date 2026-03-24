@php use App\Services\Views\Domain\Services\ViewManagerInterface; @endphp
<?php
/**
 * @var ViewManagerInterface $viewManager
 */
?>

@extends('layout::base_layout')

@section('content')
<div class="container">
    {{\App\Src\Html\Html::nav_tabs([
        ['name'=>'Настройки CRM', 'url'=>route('system_settings.crm_settings'), 'active'=>true],
        ['name'=>'Настройки системы', 'url'=>route('system_settings.settings')],
        ['name'=>'Настройки расписания', 'url'=>route('system_settings.schedule_settings')]
    ])}}
    <div class="card">
        <div class="card-body">
            {{$viewManager->renderElementByTag('settings_form')}}
        </div>
    </div>
</div>
@endsection
