@extends("layout::base_layout")

@section('content')
    <div class="container pb-4">
        {{$viewManager->renderElementByTag('table')}}
    </div>
@endsection
