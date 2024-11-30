<div class="container">
    <div class="card">
        <div class="card-header">
            Доступ
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="w-50">
                    <div class="form-group">
                        <label class="m-0">Логин</label>
                        <input id="access_login" class="form-control form-control-sm" type="text" value="{{$user->username}}">
                        <div class="error-block error-block-login"></div>
                    </div>
                    <div class="form-group">
                        <label class="m-0">Пароль</label>
                        <input id="access_password" class="form-control form-control-sm" type="password">
                        <div class="error-block error-block-password"></div>
                    </div>
                    <div class="form-group">
                        <label class="m-0">Повторите пароль</label>
                        <input id="access_password_confirm" class="form-control form-control-sm" type="password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="btn-main save-access" data-url="{{route('users_interface.tabs.set_access_tabs')}}">Сохранить</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{asset('assets/js/tabs/edits/access_edit_tab.js')}}"></script>
