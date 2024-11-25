@extends("layout::base_layout")

@section('content')
<div class="container">
    {{App\Src\Html\Html::js_table($title,[
    'name'=>'Логин', 'fio'=>'ФИО', 'email'=>'Email',
    'number_phone'=>'Мобильный телефон', 'inn'=>'ИНН',
    'snils'=>'СНИЛС', 'birthday'=>'Дата рождения'
  ], $data, route('users_interface.tabs.users_tabs'))}}
</div>
@endsection
