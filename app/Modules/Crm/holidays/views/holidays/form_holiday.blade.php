@extends('layout::base_layout')
@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/litepicker.css')}}">
    <script src="{{asset('assets/plugins/js/litepicker.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/holidays.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/daterangepicker.css')}}">
@endsection

@section('content')
    <div class="container bg-white">
        @if(isset($holiday))
            <div id="url_edit_holiday" data-id="{{$holiday->id}}" data-url="{{route('holidays.edit_holidays')}}"></div>
        @else
            <div id="url_add_holiday" data-url="{{route('holidays.add_holiday')}}"></div>
        @endif
        <h4 class="mb-3">Добавление праздников</h4>
        @csrf
        <div>
            <div class="card holiday-form">
                <div class="card-body">
                    <div class="form-group">
                        <label class="p-0">Название праздника</label>
                        <input type="text" class="form-control input-holidays" placeholder="Введите название праздника" name="name" value="{{isset($holiday)?$holiday->name:null}}">
                    </div>
                    <div class="form-group">
                        <label>Период</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                            </div>
                            <input type="text" name="period" class="form-control float-right input-holidays" id="period" value="{{isset($holiday)?sprintf('%s - %s', (new \DateTime($holiday->date_start))->format('d.m.Y'), (new \DateTime($holiday->date_end))->format('d.m.Y')):null}}">
                        </div>
                    </div>
                    <div class="form-group d-flex gap-2">
                        <label class="m-0" for="week_end">Выходные дни</label>
                        <input type="checkbox" class="form-control-sm week_end input-holidays" id="week_end" name="week_days" @if(isset($holiday) && $holiday->week_days) checked @elseif(empty($holiday)) checked @endif>
                    </div>
                    <div class="format_container d-none" id="format_container">
                        <div class="form-group">
                            <label class="p-0">Формат пар в праздничный день</label>
                            <select class="form-control input-holidays" name="format">
                                @foreach($format as $data)
                                    @if(isset($holiday))
                                        @if($data->id === $holiday->format_id)
                                            <option selected value="{{$data->id}}">{{$data->name}}</option>
                                        @else
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                        @endif
                                    @else
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="p-0">Описание праздника</label>
                        <textarea placeholder="Введите описание праздника" class="form-control input-holidays" name="description">{{isset($holiday)?$holiday->description:null}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex p-3"><div class="btn-main add-btn-holiday">
                @if(isset($holiday)) Обновить @else Создать @endif
            </div></div>
    </div>
@endsection

@section('js_files')
    <script src="{{asset('assets/modules/holidays/holidays.js')}}"></script>
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/daterangepicker.js')}}"></script>
    <script>
        //Date range picker
        $('#period').daterangepicker({
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Сохранить",
                "cancelLabel": "Назад",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1,
            }});
    </script>
@endsection
