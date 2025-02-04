<link rel="stylesheet" href="{{asset('assets/css/tabs.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/tabs/users_info.css')}}">
<div>
    @csrf
    <div class="tabs-container">
        <div class="tabs-button" id="users_info_tabs" data-url="{{route('users_interface.tabs.user_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Информация о пользователе
            </div>
        </div>
        <div class="tabs-button" id="edit_users_info_tabs" data-url="{{route('users_interface.tabs.edit_user_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Редактировать пользователя
            </div>
        </div>
        <div class="tabs-button" id="access_tabs" data-url="{{route('users_interface.tabs.get_access_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Доступ
            </div>
        </div>
        <div class="tabs-button" id="users_role_tabs" data-url="{{route('users_interface.tabs.get_role_tabs')}}">
            <div class="tabs-btn-icon"><i class="fa fa-address-card" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Группы пользователя
            </div>
        </div>
        <div class="tabs-button" id="ban_users">
            <div class="tabs-btn-icon"><i class="fa fa-ban" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Заблокировать пользователя
            </div>
        </div>
        <div class="tabs-button" id="activity_users">
            <div class="tabs-btn-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Активность
            </div>
        </div>
        <div class="tabs-button" id="massage_users">
            <div class="tabs-btn-icon"><i class="fa fa-comment" aria-hidden="true"></i></div>
            <div class="text-tabs-btn">
                Сообщения
            </div>
        </div>
    </div>
    <div class="tabs-content"></div>
</div>
<script src="{{asset('assets/js/tabs/tabs.js')}}"></script>
