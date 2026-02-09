@extends("layout::base_layout")
@section('css_files')
    @vite(App\Modules\Crm\lessons\assets\PairNumberBundle::CssFiles())
@endsection

@section('js_files')
    @vite(App\Modules\Crm\lessons\assets\PairNumberBundle::JsFiles())
@endsection

@section('content')
    <div class="container pb-4">
        <div class="card">
            <div class="card-header d-flex">
                <div class="h4">
                    {{$title}}
                </div>
                <div class="ml-auto">
                    <div class="d-flex justify-content-end">
                        <a href="{{route('lessons.action_add_pair_number')}}" class="btn btn-primary p-1">
                            Добавить <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center">
                    @if($pair_number->count())
                        <table class="table">
                            <tbody>
                            @foreach($pair_number as $val)
                                <tr pair_id="{{$val->id}}">
                                    <td class="pl-5"><div class="h5">{{$val->name}}</div></td>
                                    <td class="pr-5">
                                        <div class="d-flex justify-content-end gap-4">
                                            <div><div data-pair_id="{{$val->id}}" class="delete-user-group-btn btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></div></div>
                                            <div><a href="{{route('lessons.action_update_pair_number', ['id'=>$val->id])}}" class="btn btn-success"><i class="fa fa-wrench" aria-hidden="true"></i></a></div>
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
    <div class="url-delete-user-group" data-url="{{route('lessons.delete_pair_number')}}"></div>
    <div class="delete-panel-user-group">
        <div class="card">
            <div class="card-header">
                <strong class="me-auto">Вы уверенны что хотите удалить эту группу?</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <div class="pb-3">Эта группа будет безвозвратно утеряна</div>
                <div class="btn btn-danger p-1 send-delete-user-group">Удалить</div>
                <div class="btn btn-secondary p-1 close-delete-user-group">Назад</div>
            </div>
        </div>
    </div>
@endsection

