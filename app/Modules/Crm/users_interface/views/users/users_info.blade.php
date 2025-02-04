@extends("layout::base_layout")
@section('js_files')
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <script src="{{asset('assets/js/search_form.js')}}"></script>
@endsection

@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="container pb-4">
    <div class="card">
        <div class="card-header">{{$title}}</div>
        <div class="card-body">
            <form action="{{route('users_interface.users_info_search')}}" method="POST" class="pb-3">
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="col col-12 col-sm-12 col-lg-3">
                        <div class="search-group">
                            <label class="">Логин:</label>
                            <input type="text" name="login" class="form-control form-control-sm search-input" value="{{isset($search_data['login'])?$search_data['login']:''}}">
                        </div>
                        <div class="search-group">
                            <label class="">ФИО:</label>
                            <input type="text" name="fio" class="form-control form-control-sm search-input" value="{{isset($search_data['fio'])?$search_data['fio']:''}}">
                        </div>
                        <div class="search-group">
                            <label>Группы:</label>
                            <select name="groups[]" class="form-control select2" multiple style="width: 100%;" >
                                @foreach($users_group as $key=>$val)
                                    @if(isset($search_data['groups']) && in_array($key, $search_data['groups']))
                                        <option value="{{$key}}" selected class="option-search">{{$val}}</option>
                                    @else
                                        <option value="{{$key}}" class="option-search">{{$val}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-12 col-sm-12 col-lg-3">
                        <div class="search-group">
                            <label class="">Email:</label>
                            <input type="text" name="email" class="form-control form-control-sm search-input" value="{{isset($search_data['email'])?$search_data['email']:''}}">
                        </div>
                        <div class="search-group">
                            <label class="">ИНН:</label>
                            <input type="number" name="inn" class="form-control form-control-sm search-input" value="{{isset($search_data['inn'])?$search_data['inn']:''}}">
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="btn-main ml-auto clear-btn-user-info"><i class="fa fa-times" aria-hidden="true"></i> Очистить</div><input type="submit" class="btn-main" value="Найти">
                </div>
            </form>
            <div>
                {{
                    App\Src\Html\Html::js_table([
                        'name'=>'Логин', 'fio'=>'ФИО', 'email'=>'Email',
                        'number_phone'=>'Мобильный телефон', 'inn'=>'ИНН',
                        'snils'=>'СНИЛС', 'birthday'=>'Дата рождения'
                ], $data, route('users_interface.tabs.users_tabs'))
                }}
            </div>

        </div>
    </div>
</div>
@endsection
