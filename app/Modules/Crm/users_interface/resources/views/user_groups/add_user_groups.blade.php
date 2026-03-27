@extends("layout::base_layout")

@section('content')
    <div class="container">
        {{$viewManager->renderElementByTag('form')}}
    </div>
@endsection
