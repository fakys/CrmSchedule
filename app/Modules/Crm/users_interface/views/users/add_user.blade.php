@extends("layout::base_layout")

@section('js_files')
    <script src="{{asset('assets/js/add_user.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить пользователя</div>
            <div class="card-body">
                <form method="POST" action="{{route('users_interface.add_user_post')}}">
                    @csrf
                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username">
                        @error('username')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>ФИО</label>
                        <input type="text" class="form-control @error('fio') is-invalid @enderror"
                               title="Введите ФИО через пробел" name="fio">
                        @error('fio')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Пароль</label>
                        <div class="d-flex gap-3">
                            <input type="password" class="form-control password-input" name="password">
                            <div class="d-flex align-items-center"><div class="btn-main btn-generate-password">Сгенерировать</div></div>
                            <div class="d-flex align-items-center"><div class="btn-main bg-success btn-copy-password d-none">Копировать</div></div>
                        </div>
                    </div>
                    {{\App\Src\Html\Html::select_duallistbox_multiple('Группы пользователя', 'groups[]', $users_group)}}
                    <div class="d-flex justify-content-center"><input type="submit" class="btn-main" value="Создать"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
