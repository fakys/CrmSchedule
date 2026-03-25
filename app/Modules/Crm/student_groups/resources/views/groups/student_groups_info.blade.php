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
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('student_groups.search_student_groups_info')}}" method="POST" class="pb-3">
                    @csrf
                    <div class="row d-flex">
                        <div class="">
                            <div class="search-group">
                                <label class="">Номер группы</label>
                                <input type="text" name="number" class="form-control form-control-sm search-input" value="{{isset($search_data['number'])?$search_data['number']:''}}">
                            </div>
                            <div class="search-group">
                                <label class="">Название:</label>
                                <input type="text" name="name" class="form-control form-control-sm search-input" value="{{isset($search_data['name'])?$search_data['name']:''}}">
                            </div>
                            <div class="search-group">
                                <label>Специальности:</label>
                                <select name="specialties[]" class="form-control select2" multiple style="width: 100%;" >
                                    @foreach($specialties as $key=>$val)
                                        @if(isset($search_data['specialties']) && in_array($key, $search_data['specialties']))
                                            <option value="{{$key}}" selected class="option-search">{{$val}}</option>
                                        @else
                                            <option value="{{$key}}" class="option-search">{{$val}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="btn-main ml-auto clear-btn-user-info"><i class="fa fa-times" aria-hidden="true"></i> Очистить</div><input type="submit" class="btn-main" value="Найти">
                    </div>
                </form>
                <div>
                    {{\App\Src\Html\Html::js_table([
            'number'=>'Номер группы', 'name'=>'Название группы', 'specialties'=>'Специальность', 'specialty_description'=>'Описание специальности'
            ], $data, route('users_interface.get_tab_for_student_groups'))}}
                </div>
            </div>
        </div>
    </div>
@endsection
