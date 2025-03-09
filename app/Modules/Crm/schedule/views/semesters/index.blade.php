@extends("layout::base_layout")

@section('content')
    @csrf
    <div class="container pb-4">
        <div class="card">
            <div class="card-header d-flex">
                <div class="h4">
                    {{$title}}
                </div>
                <div class="ml-auto">
                    <div class="d-flex justify-content-end">
                        <a href="{{route('schedule.add_semesters')}}" class="btn btn-primary p-1">
                            Добавить <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center">
                    @if($semesters)
                        <div class="table">
                            @foreach($semesters as $key=>$semester)
                                <div class="card card-primary card-semesters">
                                    <div class="semester-year-container">
                                        <div class="semester-year">{{$key}}</div>

                                        <div class="card-tools close-btn-schedule-menu ml-auto d-flex align-items-center">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($semester as $val)
                                            <div semesters="{{$val->id}}" class="d-flex align-items-center semester-row">
                                                <div class="pl-5"><div class="h5">{{$val->name}}</div></div>
                                                <div class="semester-date">{{(new DateTime($val->date_start))->format('d.m.Y')}}-{{(new DateTime($val->date_end))->format('d.m.Y')}}</div>
                                                <div class="pr-5 ml-auto">
                                                    <div class="d-flex justify-content-end gap-4">
                                                        <div><div data-semester_id="{{$val->id}}" class="delete-semesters-btn btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></div></div>
                                                        <div><a href="{{route('schedule.semester_edit', ['semester_id'=>$val->id])}}" class="btn btn-success"><i class="fa fa-wrench" aria-hidden="true"></i></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @else
                        <div class="h5 text-center">Пусто</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="url-delete-semesters" data-url="{{route('schedule.delete_semester')}}"></div>
    <div class="delete-panel-semesters">
        <div class="card">
            <div class="card-header">
                <strong class="me-auto">Вы уверенны что хотите удалить этот семестр?</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <div class="pb-3">Это семестр будет безвозвратно утеряна</div>
                <div class="btn btn-danger p-1 send-delete-semesters">Удалить</div>
                <div class="btn btn-secondary p-1 close-delete-semesters">Назад</div>
            </div>
        </div>
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/js/semesters.js')}}"></script>
@endsection
