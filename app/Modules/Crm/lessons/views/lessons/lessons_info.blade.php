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
                                <input type="text" name="name" class="form-control form-control-sm search-input"
                                       value="{{isset($search_data['name'])?$search_data['name']:''}}">
                            </div>
                            <div class="search-group">
                                <label class="">Полное название:</label>
                                <input type="text" name="full_name" class="form-control form-control-sm search-input"
                                       value="{{isset($search_data['full_name'])?$search_data['full_name']:''}}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{route('lessons.add_lesson')}}" class="btn-main ml-auto">Добавить</a>
                        <div class="btn-main clear-btn-user-info"><i class="fa fa-times" aria-hidden="true"></i>
                            Очистить
                        </div>
                        <input type="submit" class="btn-main" value="Найти">
                    </div>
                </form>
                {{\App\Src\Html\Html::js_table([
    'fio'=>'Фио преподавателя', 'subject_full_name'=>'Название предмета']
    , $lessons, route('lessons.get_tabs'))}}
            </div>
        </div>
    </div>

@endsection
