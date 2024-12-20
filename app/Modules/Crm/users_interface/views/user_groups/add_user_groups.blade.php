@extends("layout::base_layout")

@section('content')
    <div class="container">
        <form method="post" action="{{route('users_interface.create_user_groups')}}">
            @csrf
            <div>
                <div class="form-group">
                    <label>Название группы</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Введите название">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    {{\App\Src\Html\Html::select_duallistbox_multiple('Роли(Доступы)', 'accesses[]', $access)}}
                </div>
                <div class="form-group">
                    <label>Описание группы</label>
                    <textarea class="form-control @error('name') is-invalid @enderror" name="description"></textarea>
                    @error('description')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{\App\Src\Html\Html::checkbox('Активная группа', 'active', true)}}
                </div>
            </div>
            <div>
                <input type="submit" class="btn-main" value="Добавить">
            </div>
        </form>
    </div>
@endsection
