@php use App\Services\Views\Domain\Services\ViewManagerInterface; @endphp
<?php
/**
 * @var ViewManagerInterface $viewManager
 */
?>

@extends('layout::auth_layout')

@section('content')
    <div class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <div class="h1">CRM</div>
            </div>
            <div class="card-body">
                {{$viewManager->renderElementByTag('login_form')}}
                <p class="mb-1">
                    <a href="forgot-password.html">Забыл пароль</a>
                </p>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
@endsection
