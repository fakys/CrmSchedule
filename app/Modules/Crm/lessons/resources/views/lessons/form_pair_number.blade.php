@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{$title}}</div>
            <div class="card-body">
                {{$viewManager->renderElementByTag('form_pair')}}
            </div>
        </div>
    </div>
@endsection
