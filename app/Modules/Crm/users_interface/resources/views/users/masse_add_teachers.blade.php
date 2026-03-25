@extends("layout::base_layout")

@section('content')
    {{$assetsBundleManager->registerFile('app/Modules/Crm/users_interface/resources/js/masseAddTeachers.js')}}
    <div id="download_template_url" data-url="{{route('users_interface.download_template_masse_add_teacher')}}"></div>
    <div class="container">
        <div class="card">
            <div class="card-header">Массовое добавление учителей</div>
            <div class="card-body">
                <form action="{{route('users_interface.masse_add_teacher')}}" method="post" enctype="multipart/form-data" class="input-group d-flex flex-column gap-2" id="add_plan_schedule_excel">
                    @csrf
                    <label>Загрузить учителей через Excel:</label>
                    <div class="d-flex gap-3">
                        <input type="file" name="file" class="form-control" id="download_schedule_file_input" style="width: 300px">
                        <div class="">
                            <button type="submit" class="btn btn-secondary" id="download_schedule_file">Загрузить</button>
                        </div>
                    </div>
                    @error('file')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </form>
                <div>
                    <div class="text-primary cursor-pointer" id="download_template">Загрузить шаблон</div>
                </div>
            </div>
        </div>
    </div>
@endsection
