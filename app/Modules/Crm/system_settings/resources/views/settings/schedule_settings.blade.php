<?php
/**
 * @var \App\Services\AssetsBundle\Domain\Services\AssetsBundleManagerInterface $assetsBundleManager
 */
?>
@extends('layout::base_layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                {{$viewManager->renderElementByTag('settings_form')}}
            </div>
        </div>
    </div>
@endsection
