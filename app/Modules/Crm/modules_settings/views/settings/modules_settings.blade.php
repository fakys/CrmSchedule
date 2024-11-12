@extends('layout::base_layout')
@section('content')

    <div class="container">
        <div class="alert alert-main  d-none" role="alert">
            Изменения сохранены
        </div>
        {{\App\Src\Html\Html::nav_tabs([
            ['name'=>'Статус модулей', 'url'=>route('modules_settings.settings'), 'active'=>true],
            ['name'=>'Добавить модуль', 'url'=>route('modules_settings.add_module')]
        ])}}
        <div class="card">
            <form action="{{route('modules_settings.save_status_modules')}}" class="card-body form-settings-module">
                <table class="table">
                    @csrf
                    <thead>
                    <tr>
                        <th scope="col">Модуль</th>
                        <th scope="col">Название</th>
                        <th scope="col">Настройки</th>
                        <th scope="col">Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modules as $module)
                        <tr class="row-{{$module['module']->getNameModule()}}">
                            <td>{{$module['module']->getRuNameModule()}}</td>
                            <td>{{$module['module']->getNameModule()}}</td>
                            <td><a href="#" class="btn-main">Настройки</a></td>
                            <td>
                                <div class="pl-3">
                                    <div class="form-group-container">
                                        <div class="custom-control custom-switch">
                                            <input data-module_name="{{$module['module']->getNameModule()}}" name="module-{{$module['module']->getNameModule()}}"
                                                   type="checkbox" class="custom-control-input modules-settings-checkbox"
                                                   id="module_{{$module['module']->getNameModule()}}"
                                                   data-module="{{$module['module']->getNameModule()}}"
                                                   @if($module['status_module']) checked @endif
                                            >
                                            <label class="custom-control-label" for="module_{{$module['module']->getNameModule()}}"></label>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pt-3 d-flex">
                    <div class="btn-main save-modules-settings">Сохранить</div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/js/modules_settings.js')}}"></script>
@endsection
