<link rel="stylesheet" href="{{asset('assets/css/schedule_style.css')}}">
<div class="container pt-3">
    @foreach($schedules as $schedule_group_data)
        <div class="schedule-container">
            <div>
                @foreach($schedule_group_data as $group_name => $schedule_group)
                    <div class="card card-primary">
                        <div class="container-header-schedule">
                            <div class="schedule-name-group">{{$group_name}}</div>

                            <div class="card-tools close-btn-schedule-menu">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="schedule-data-container">
                                @foreach($schedule_group as $date=>$schedule_data)
                                    <div>
                                        <div class="d-flex pb-3"><div class="schedule-date">{{$date}}</div></div>
                                        <div class="schedule-pair-data-container">
                                            @foreach($schedule_data as $number_pair=>$schedule)
                                                <div class="d-flex gap-4 schedule-row">
                                                    <div class="schedule-pair-number">{{$number_pair}}</div>
                                                    <div class="name-subject-container">
                                                        @if(isset($schedule['schedule']))
                                                            <div class="d-flex gap-3">
                                                                <div>{{$schedule['schedule']->subject_name}}</div>
                                                                <div class="fio-teacher-schedule">{{$schedule['schedule']->fio_teacher}}</div>
                                                            </div>
                                                        @else
                                                            <div>
                                                                Нет данных
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="container edit-container-schedule d-none">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            Редактор расписания
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Предмет</label>
                                                                        <select class="form-control-sm">
                                                                            <option>test1</option>
                                                                            <option>test2</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Время начала</label>
                                                                        <input class="form-control-sm" type="time">
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Номер пары</label>
                                                                        <select class="form-control-sm">
                                                                            <option>test1</option>
                                                                            <option>test2</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Формат предмета</label>
                                                                        <select class="form-control-sm">
                                                                            <option>test1</option>
                                                                            <option>test2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Преподаватель</label>
                                                                        <select class="form-control-sm">
                                                                            <option>test1</option>
                                                                            <option>test2</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Время окончания</label>
                                                                        <input class="form-control-sm" type="time">
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Дата начала</label>
                                                                        <input class="form-control-sm" type="date">
                                                                    </div>
                                                                    <div class="form-group d-flex flex-column">
                                                                        <label>Группа</label>
                                                                        <select class="form-control-sm">
                                                                            <option>test1</option>
                                                                            <option>test2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <div class="col-12 d-flex justify-content-center">
                                                                <div class="form-group d-flex flex-column">
                                                                    <label>Описание</label>
                                                                    <textarea class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            </div>
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
                @endforeach

            </div>
        </div>
    @endforeach
</div>
<script src="{{asset('assets/js/schedule_table.js')}}"></script>
