@extends('layout::base_layout')

@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/table/css/table.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/daterangepicker.css')}}">
@endsection
@section('js_files')
    <script src="{{asset('assets/table/js/table.js')}}"></script>
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/js/report_for_group.js')}}"></script>
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

@section('content')
    <script>
        var export_url = '{{route('reports.export_excel')}}'
        var check_export_url = '{{route('reports.check_export_excel')}}'
        var download_export_excel = '{{route('reports.download_export_excel')}}'
    </script>
    <div class="container">
        <form action="{{route('reports.report_for_teachers')}}" class="row" method="POST" id="searchForm">
            @csrf()
            <div class="col-sm-6 col-lg-3">
                <div>
                    <div class="">
                        {{App\Src\Html\Html::select_search('Преподаватели', 'teachers', $teachers, $search_data['teachers']??[])}}
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-9 d-flex">
                <div class="ml-auto">
                    <div>
                        <label>Период</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                            </div>
                            <input type="text" name="period" class="form-control float-right" id="period" value="{{$search_data['period']??''}}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{(new App\Modules\Crm\reports\components\ReportsComponent(
    [
        'fio'=>'Фио преподавателя', 'user_name'=>'Логин преподавателя',
        'semester_name'=>'Название семестра','count_hours_period'=>'Количество рабочих часов в периоде',
        'average_count_hours_week'=>'Среднее количество часов в неделю',
        'count_hours_semester'=>'Количество рабочих часов в семестре'
    ],
    $data,
    ['period'=>'Период'],
    $task_name
    ))->render()}}
@endsection
