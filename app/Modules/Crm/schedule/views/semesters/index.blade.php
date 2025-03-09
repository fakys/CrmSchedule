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
                    @if($semesters->count())
                        <table class="table">
                            <tbody>
                            @foreach($semesters as $val)
                                <tr semesters="{{$val->id}}">
                                    <td class="pl-5"><div class="h5">{{$val->name}}</div></td>
                                    <td class="pr-5">
                                        <div class="d-flex justify-content-end gap-4">
                                            <div><div data-semester_id="{{$val->id}}" class="delete-semesters-btn btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></div></div>
                                            <div><a href="{{route('schedule.semester_edit', ['semester_id'=>$val->id])}}" class="btn btn-success"><i class="fa fa-wrench" aria-hidden="true"></i></a></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
