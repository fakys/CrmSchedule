@extends("layout::base_layout")

@section('content')
    {{\App\Src\Html\Html::js_table([
    'name'=>'Название', 'full_name'=>'Полное название',
     'description'=>'Описание', 'created_at'=>'Дата добавления']
    , $subjects, route('users_interface.get_tab_for_subjects'))}}
@endsection
