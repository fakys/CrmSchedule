@extends("layout::base_layout")
@section('js_files')
    <script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
    <script>
        $('[data-mask]').inputmask()
    </script>
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
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
                            <input type="text" name="login" class="form-control form-control-sm">
                        </div>
                        <div class="search-group">
                            <label class="">ФИО:</label>
                            <input type="text" name="fio" class="form-control form-control-sm">
                        </div>
                        <div class="search-group">
                            <label class="">Номер:</label>
                            <input type="text" class="form-control form-control-sm"  name="number"
                                   pattern="Номер телефона..."
                                   data-inputmask="'mask': ['999-999-9999', '+7 999-999-9999']" data-mask=""
                                   inputmode="text" value="">
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-12 col-sm-12 col-lg-3">
                        <div class="search-group">
                            <label class="">Email:</label>
                            <input type="text" name="email" class="form-control form-control-sm">
                        </div>
                        <div class="search-group">
                            <label class="">ИНН:</label>
                            <input type="number" name="inn" class="form-control form-control-sm">
                        </div>
                        <div class="search-group">
                            <label>Группы:</label>
                            <select name="groups[]" class="form-control select2" multiple style="width: 100%;" >
                                @foreach($users_group as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <input type="submit" class="btn-main ml-auto" value="Найти">
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
