<div class="container">
    <div class="card-header"><div class="h5">Группы пользователя</div></div>
    <div class="card">
        <div class="card-body d-flex justify-content-center">
            {{App\Src\Html\Html::select_duallistbox_multiple('', 'user_groups', ['name', 'test', 'test2'])}}
        </div>
    </div>
</div>
