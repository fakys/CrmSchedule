<div class="pb-2">Неделя <b>№{{$number_week}}</b></div>
<div class="week-container" data-number_week="{{$number_week}}">
    <div class="week-day-container">
        <div>
            <div class="week-day-name">ПН</div>
        </div>
        <div class="week-form-container">
            <div class="form-group">
                <div class="form-group-week-day">
                    <label for="week_end_1">Выходной</label>
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="1" id="week_end_1">
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
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="2" id="week_end_2">
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
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="3" id="week_end_3">
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
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="4" id="week_end_4">
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
                    <input type="checkbox" class="form-control-sm weekend-input" data-week_end="5" id="week_end_5">
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
                    <input type="checkbox" class="form-control-sm weekend-input" @if($five_day) checked
                           @endif data-week_end="6" id="week_end_6">
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
                    <input type="checkbox" class="form-control-sm weekend-input" checked data-week_end="0" id="week_end_0">
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>
