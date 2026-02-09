@extends("layout::base_layout")

@section('js_files')
    @vite(\App\Assets\SearchFormBundle::JsFiles())
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{$title}}
            </div>
            <div class="card-body">
                <form action="{{route('lessons.subjects_info')}}" method="POST" class="pb-3">
                    @csrf
                    <div class="row d-flex ">
                        <div>
                            <div class="search-group">
                                <label class="">Название:</label>
                                <input type="text" name="name" class="form-control form-control-sm search-input" value="{{isset($search_data['name'])?$search_data['name']:''}}">
                            </div>
                            <div class="search-group">
                                <label class="">Полное название:</label>
                                <input type="text" name="full_name" class="form-control form-control-sm search-input" value="{{isset($search_data['full_name'])?$search_data['full_name']:''}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="btn-main ml-auto clear-btn-user-info"><i class="fa fa-times" aria-hidden="true"></i> Очистить</div><input type="submit" class="btn-main" value="Найти">
                    </div>
                </form>

                {{\App\Src\Html\Html::js_table([
    'name'=>'Название', 'full_name'=>'Полное название',
     'description'=>'Описание', 'created_at'=>'Дата добавления']
    , $subjects, route('users_interface.get_tab_for_subjects'))}}
            </div>
        </div>
    </div>

@endsection
