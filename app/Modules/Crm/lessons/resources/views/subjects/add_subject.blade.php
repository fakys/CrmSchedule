@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить предмет</div>
            <div class="card-body">
                {{$viewManager->renderElementByTag('add_subject')}}
            </div>
        </div>
    </div>
@endsection
