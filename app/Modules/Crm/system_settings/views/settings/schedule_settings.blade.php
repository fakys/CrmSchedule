<?php
/**
 * @var \App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface $assetsBundleManager
 */
?>
@extends('layout::base_layout')

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
            ['name'=>'Настройки CRM', 'url'=>route('system_settings.crm_settings')],
            ['name'=>'Настройки системы', 'url'=>route('system_settings.settings')],
            ['name'=>'Настройки расписания', 'url'=>route('system_settings.schedule_settings'), 'active'=>true]
        ])}}
        <div class="card">
            <div class="card-body">
                {{$viewManager->renderElementByTag('settings_form')}}
            </div>
        </div>
    </div>
@endsection
