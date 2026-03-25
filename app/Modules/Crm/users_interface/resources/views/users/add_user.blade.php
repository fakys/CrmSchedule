@extends("layout::base_layout")

@section('js_files')
    <script src="{{asset('assets/js/add_user.js')}}"></script>
@endsection

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
