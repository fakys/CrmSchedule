<div class="d-flex"><div class="pb-2">Неделя <b>№{{$number_week}}</b></div><div class="ml-auto"><div class="btn btn-danger delete-weeks" data-number="{{$number_week}}"><i class="fas fa-times"></i></div></div></div>
<div class="week-container" data-number_week="{{$number_week}}">
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ПН</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_1">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="1" id="week_end_1" @if(isset($week_data['week_end'][1]) && $week_data['week_end'][1] != 'false') checked @endif >
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ВТ</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_2">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="2" id="week_end_2" @if(isset($week_data['week_end'][2]) && $week_data['week_end'][2] != 'false') checked @endif>
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">СР</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_3">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="3" id="week_end_3" @if(isset($week_data['week_end'][3]) && $week_data['week_end'][3] != 'false') checked @endif">
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ЧТ</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_4">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="4" id="week_end_4" @if(isset($week_data['week_end'][4]) && $week_data['week_end'][4] != 'false') checked @endif>
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ПТ</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_5">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="5" id="week_end_5" @if(isset($week_data['week_end']) && $week_data['week_end'][5] != 'false') checked @endif>
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">СБ</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_6">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input"
                           @if(isset($week_data['week_end'][6]) && $week_data['week_end'][6] != 'false') checked @elseif(empty($week_data['week_end'][6]) && $five_day) checked @endif data-week_end="6" id="week_end_6">
                </div>
            </div>
        </div>
    </div>
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ВС</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_0">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" @if(isset($week_data['week_end']) && !$week_data['week_end'][0] == 'false')  @else checked @endif  data-week_end="0" id="week_end_0">
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>

<div class="delete-panel-type-schedule-week" number="{{$number_week}}">
    <div class="card">
        <div class="card-header">
            <strong class="me-auto">Вы уверенны что хотите удалить Неделю <b>№{{$number_week}}</b>?</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="card-body">
            <div class="pb-3">Это может привести к потери расписания</div>
            <div class="btn btn-danger p-1 send-delete-type-schedule-week" data-number="{{$number_week}}">Удалить</div>
            <div class="btn btn-secondary p-1 close-delete-type-schedule-week" data-number="{{$number_week}}">Назад</div>
        </div>
    </div>
</div>


<script src="{{asset('assets/js/add_type_schedule_week.js')}}"></script>
