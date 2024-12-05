@extends("layout::base_layout")

@section('content')
    <div class="container">
        <form method="post" action="">
            @csrf
            <div>
                <div class="form-group">
                    <label>Название группы</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div>
                    {{\App\Src\Html\Html::select_duallistbox_multiple('Роли(Доступы)', 'roles', [], [])}}
                </div>
            </div>
            <div>
                <input type="submit" class="btn-main" value="Добавить">
            </div>
        </form>
    </div>
@endsection
