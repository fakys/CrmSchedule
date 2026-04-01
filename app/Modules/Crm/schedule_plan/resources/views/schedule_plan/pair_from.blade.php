<div>
    <form>
        <div id="card_id_pair_form" data-card_id="{{$card_id}}"></div>
        {{$viewManager->renderElementByTag('user')}}
        <div class="subject-input-container">
            @if($subject)
                {{$viewManager->renderElementByTag('subject')}}
            @endif
        </div>
        {{$viewManager->renderElementByTag('format')}}
        <div class="form-group">
            <label>Время начала</label>
            <input class="form-control-sm schedule-input" name="time_start" type="time" value="{{$data['time_start']??null}}">
            <div class="error-block"></div>
        </div>
        <div class="form-group">
            <label>Время окончания</label>
            <input class="form-control-sm schedule-input" name="time_end" type="time" value="{{$data['time_end']??null}}">
            <div class="error-block"></div>
        </div>
        <div class="form-group">
            <label class="p-0">Описание расписания</label>
            <textarea class="form-control schedule-input" name="description">{{$data['description']??null}}</textarea>
            <div class="error-block"></div>
        </div>
    </form>
</div>
