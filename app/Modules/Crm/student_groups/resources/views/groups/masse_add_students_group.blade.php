@extends("layout::base_layout")

@section('content')
    {{$assetsBundleManager->registerFile('app/Modules/Crm/student_groups/resources/js/masseAddGroups.js')}}
    <div id="download_template_url" data-url="{{route('student_groups.download_template_masse_add_students_group')}}"></div>
    <div class="container">
        <div class="card">
            <div class="card-header">Массовое добавление групп студентов</div>
            <div class="card-body">
                <form action="{{route('student_groups.masse_add_students_group')}}" method="post" enctype="multipart/form-data" class="input-group d-flex flex-column gap-2">
                    @csrf

                    {{$viewManager->renderElementByTag('speciality')}}

                    <div class="form-group">
                        <label>Загрузить групп студентов через Excel:</label>
                        <div class="d-flex gap-3">
                            <input type="file" name="file" class="form-control" style="width: 300px">
                            <div class="">
                                <button type="submit" class="btn btn-secondary" id="download_schedule_file">Загрузить</button>
                            </div>
                        </div>
                        @error('file')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
                <div>
                    <div class="text-primary cursor-pointer" id="download_template">Загрузить шаблон</div>
                </div>
            </div>
        </div>
    </div>
@endsection
