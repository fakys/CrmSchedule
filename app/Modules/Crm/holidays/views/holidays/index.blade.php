@extends('layout::base_layout')
@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/litepicker.css')}}">
    <script src="{{asset('assets/plugins/js/litepicker.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/holidays.css')}}">
@endsection

@section('content')
    <div class="container">
        {{\App\Src\Html\Html::nav_tabs([
        ['name'=>'Общие настройки', 'url'=>route('holidays.settings')],
        ['name'=>'Настройки по дате', 'url'=>route('holidays.holidays'), 'active'=>true]
    ])}}
        <div id="url_delete" data-url="{{route('holidays.delete_holidays')}}"></div>
        <div class="p-3 bg-white container">
            <h4 class="mb-3">Настройки праздничных дней по датам</h4>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex"><a href="{{route('holidays.add_action_holiday')}}" class="btn-main ml-auto">Добавить</a></div>
                    <div class="pt-3">
                        @foreach($holidays as $date=>$holiday_data)
                            <div class="card">
                                <div class="card-header bg-primary date-card-header">
                                    {{$date}}
                                </div>
                                <div class="card-body">
                                    @foreach($holiday_data as $holiday)
                                        <div class="d-flex mb-2">
                                            <div class="d-flex align-items-center">
                                                {{$holiday->name}}
                                            </div>
                                            <a href="{{route('holidays.edit_action_holidays', ['id'=>$holiday->id])}}" class="btn btn-success ml-auto">
                                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                            </a>
                                            <div class="btn btn-danger ml-2 btn-open-delete-menu" data-id="{{$holiday->id}}">
                                                <i class="fa fa-ban" aria-hidden="true"></i>
                                            </div>
                                        </div>

                                        <div class="delete-menu-container" style="display: none" id="{{$holiday->id}}">
                                            <div class="delete-menu">
                                                <div class="delete-massage">
                                                    Вы уверенны что хотите удалить праздник "{{$holiday->name}}"?
                                                </div>
                                                <div class="d-flex">
                                                    <div class="btn-danger btn menu-btn-delete" data-id="{{$holiday->id}}">Удалить</div>
                                                    <div class="btn-secondary btn ml-3 close-btn-delete" data-id="{{$holiday->id}}">Отмена</div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/modules/holidays/holidays.js')}}"></script>
@endsection
