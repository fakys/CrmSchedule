@extends("layout::base_layout")

@section('content')
    <div class="container pb-4">
        {{App\Src\Html\Html::js_table([
        'id'=>'#', 'name'=>'Название', 'url'=>'Url',
        'description'=>'Описание'
      ], $data)}}
    </div>
@endsection
