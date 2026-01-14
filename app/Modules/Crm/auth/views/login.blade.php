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
                <form action="{{route('auth.login')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="username" type="text" class="form-control
{{--                        @error('username') is-invalid @enderror--}}
                        " placeholder="Логин" value="{{old('username')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Пароль">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input name="remember" type="checkbox" id="remember">
                                <label for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">Забыл пароль</a>
                </p>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
@endsection
