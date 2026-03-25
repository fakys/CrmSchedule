@extends("layout::base_layout")

@section('content')
    <div class="container">
        <form method="post" action="{{isset($group)?route('users_interface.edit_users_group_action',
            ['group_id'=>$group->id]):
            route('users_interface.create_user_groups')}}">
            @csrf
            <div>
                <input type="text" class="d-none" value="{{isset($group)?$group->id:null}}" name="group_id">
                <div class="form-group">
                    <label>Название группы</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Введите название"
                           value="<?=isset($group)?$group->name:''?>">
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    {{\App\Src\Html\Html::select_duallistbox_multiple('Роли(Доступы)', 'accesses[]', $access, isset($access_data)?$access_data:[])}}
                </div>
                <div class="form-group">
                    <label>Описание группы</label>
                    <textarea class="form-control @error('name') is-invalid @enderror" name="description"><?=isset($group)?$group->description:''?></textarea>
                    @error('description')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{\App\Src\Html\Html::checkbox('active', 'Активная группа', isset($group)?$group->active:true)}}
                </div>
            </div>
            <div>
                <input type="submit" class="btn-main" value="Сохранить">
            </div>
        </form>
    </div>
@endsection
