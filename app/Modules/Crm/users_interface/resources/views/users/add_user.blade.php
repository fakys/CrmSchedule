@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить пользователя</div>
            <div class="card-body">
                {{$viewManager->renderElementByTag('form')}}
            </div>
        </div>
    </div>
@endsection
