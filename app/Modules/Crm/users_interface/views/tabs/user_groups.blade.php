<div class="container">
    <div class="card-header"><div class="h5">Группы пользователя</div></div>
    <div class="card">
        <div class="card-body d-flex justify-content-center">
            {{
                App\Src\Html\Html::select_duallistbox_multiple('', 'user_groups',
                \App\Src\helpers\ArrayHelper::getColumn($users_groups, 'name', 'id'),
                \App\Src\helpers\ArrayHelper::getColumn($user_in_group, 'user_group_id'),
                'users-group-select')
            }}
        </div>
        <div class="d-flex justify-content-center pb-3">
            <div class="btn-main save-groups" data-url="{{route('users_interface.add_user_groups')}}">Сохранить</div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/tabs/edits/user_groups_edit.js')}}"></script>
