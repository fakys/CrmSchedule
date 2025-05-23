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
        <form action="{{route('reports.report_for_group')}}" class="row" method="POST" id="searchForm">
            @csrf()
            <div class="col-sm-6 col-lg-3">
                <div>
                    <div class="search-group">
                        {{App\Src\Html\Html::select_search('Группы студентов', 'students_group', $students_groups, $search_data['students_group']??[])}}
                    </div>
                </div>
                <div>
                    <div class="search-group">
                        {{App\Src\Html\Html::select_search('Специальности', 'specialties', $specialties, $search_data['specialties']??[])}}
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
                            <input type="text" name="period" class="form-control float-right" id="period" value="{{isset($search_data['period'])?$search_data['period']:null}}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{(new App\Modules\Crm\reports\components\ReportsComponent(
    [
        'group_name'=>'Название группы', 'group_number'=>'Номер группы',
        'specialties_number'=>'Номер специальности', 'specialties_name'=>'Название специальности',
        'semester_name'=>'Название семестра','count_hours_period'=>'Количество учебных часов в периоде',
        'average_count_hours_week'=>'Среднее количество часов в неделю',
        'count_hours_semester'=>'Количество учебных часов в семестре'
    ],
    $data,
    ['period'=>'Период'],
    $task_name
    ))->render()}}
@endsection
