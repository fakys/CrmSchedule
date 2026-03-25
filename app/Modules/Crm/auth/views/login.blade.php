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
                {{$viewManager->renderElement($viewManager->getElementByTag('login_form')->startForm())}}
                @if($viewManager->getElementByTag('login_form')->hasElement('login'))
                    {{$viewManager->renderElement($viewManager->getElementByTag('login_form')->getElementByTag('login'))}}
                @endif
                @if($viewManager->getElementByTag('login_form')->hasElement('password'))
                    {{$viewManager->renderElement($viewManager->getElementByTag('login_form')->getElementByTag('password'))}}
                @endif
                @if($viewManager->getElementByTag('login_form')->hasElement('remember'))
                    <div class="form-check">{{$viewManager->renderElement($viewManager->getElementByTag('login_form')->getElementByTag('remember'))}}</div>
                @endif
                @if($viewManager->getElementByTag('login_form')->hasElement('submit'))
                    <div class="d-flex justify-content-center">
                        {{$viewManager->renderElement($viewManager->getElementByTag('login_form')->getElementByTag('submit'))}}
                    </div>
                @endif
                <p class="mb-1">
                    <a href="forgot-password.html">Забыл пароль</a>
                </p>
                {{$viewManager->renderElement($viewManager->getElementByTag('login_form')->endForm())}}
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
@endsection
