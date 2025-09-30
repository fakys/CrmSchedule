<div>
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <form>
        <div id="card_id_pair_form" data-card_id="{{$card_id}}"></div>
        {{\App\Src\Html\Html::select_search('Преподаватель', 'user', $users, [$data['user']??null], 'users_select schedule-input', false, false)}}
        {{\App\Src\Html\Html::select_search('Предмет', 'subject', $subject, [$data['subject']??null], 'subject_select schedule-input', false, false)}}
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



    <script>
        $(document).ready(function (){
            $('.users_select').select2()
            $('.subject_select').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
</div>
