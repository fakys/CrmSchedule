@extends("layout::base_layout")

@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/daterangepicker.css')}}">
@endsection

@section('js_files')
    <script src="{{asset('assets/js/schedule_manager.js')}}"></script>
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js/daterangepicker.js')}}"></script>
    <script>
        //Date range picker
        $('#period').daterangepicker({ "locale": {
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
    @csrf
    <div class="d-none url-manager-menu" data-url="{{route('schedule.schedule_manager_menu')}}"></div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{$title}}
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Период</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                        </div>
                        <input type="text" name="period" class="form-control float-right" id="period" value="{{isset($session_data['period'])?$session_data['period']:null}}">
                    </div>
                </div>
                <div class="form-group">
                    {{\App\Src\Html\Html::select_search('Группы', 'groups', $student_group, isset($session_data['groups'])?$session_data['groups']:[], 'student_groups')}}
                </div>
                <div class="form-group">
                    {{\App\Src\Html\Html::select_search('Специальности', 'specialties', $specialties, isset($session_data['specialties'])?$session_data['specialties']:[], 'specialties')}}
                </div>
                <div class="form-group">
                    <button class="btn-main" id="btn_search_manager">Найти</button>
                </div>
            </div>
            <div>
                <div class="schedule-manager-menu"></div>
            </div>

        </div>
    </div>
@endsection
