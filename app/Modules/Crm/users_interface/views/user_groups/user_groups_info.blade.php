@extends("layout::base_layout")

@section('content')
<div class="container pb-4">
    <div class="card">
        <div class="card-header d-flex">
            <div class="h4">
                {{$title}}
            </div>
            <div class="ml-auto">
                <div class="d-flex justify-content-end">
                    <a href="{{route('users_interface.user_groups_add')}}" class="btn btn-primary p-1">
                        Добавить <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column justify-content-center">
                @if($user_groups->count())
                <table class="table">
                    <tbody>
                    @foreach($user_groups as $val)
                        <tr>
                            <td class="pl-5"><div class="h5">{{$val->name}}</div></td>
                            <td class="pr-5">
                                <div class="d-flex justify-content-end gap-4">
                                    <div><a href="#" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                    <div><a href="#" class="btn btn-success"><i class="fa fa-wrench" aria-hidden="true"></i></a></div>
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
@endsection
