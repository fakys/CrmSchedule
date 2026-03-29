@extends("layout::base_layout")

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
                                {{$viewManager->renderElementByTag('specialties')}}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="btn-main ml-auto clear-btn-user-info"><i class="fa fa-times" aria-hidden="true"></i> Очистить</div><input type="submit" class="btn-main" value="Найти">
                    </div>
                </form>
                <div>
                    {{$viewManager->renderElementByTag('table')}}
                </div>
            </div>
        </div>
    </div>
@endsection
