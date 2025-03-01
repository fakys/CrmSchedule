<link rel="stylesheet" href="{{asset('assets/css/schedule_style.css')}}">

<div class="btn-save-manager-container">
    <button class="btn-main btn-save-schedule">Сохранить</button>
</div>
<div class="url-edit-schedule" data-url="{{route('schedule.edit_schedule_manager')}}"></div>
<div class="container pt-3">
    <div class="schedule-errors-block"></div>
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
                                                <div class="schedule-block" data-date="{{$date}}" data-pair_number="{{$number_pair}}" data-student_group="{{$schedule['student_group']}}">
                                                    <div class="d-flex gap-4 schedule-row">
                                                        <div class="schedule-pair-number">{{$number_pair}}</div>
                                                        <div class="name-subject-container">
                                                            @if(isset($schedule['schedule']))
                                                                <div class="d-flex gap-3">
                                                                    <div>{{$schedule['schedule']->subject_name}}</div>
                                                                    <div class="fio-teacher-schedule">{{$schedule['schedule']->fio_teacher}}</div>
                                                                    <div class="time-start-end">{{(new DateTime($schedule['schedule']->time_start))->format('H:i')}} - {{(new DateTime($schedule['schedule']->time_end))->format('H:i')}}</div>
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
                                                                            <select class="form-control-sm change-input" name="subject_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($subjects as $subject)
                                                                                    @if(isset($schedule['schedule']))
                                                                                        @if($subject->id === $schedule['schedule']->subject_id)
                                                                                            <option selected value="{{$subject->id}}">{{$subject->name}}</option>
                                                                                        @else
                                                                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Время начала</label>
                                                                            <input class="form-control-sm change-input" name="time_start" type="time" value="{{isset($schedule['schedule'])? $schedule['schedule']->time_start : ''}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Номер пары</label>
                                                                            <select class="form-control-sm change-input" name="pair_number">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($pair_number as $number)
                                                                                    @if(isset($schedule['schedule']))
                                                                                        @if($number->id === $schedule['schedule']->pair_id)
                                                                                            <option selected value="{{$number->id}}">{{$number->name}}</option>
                                                                                        @else
                                                                                            <option value="{{$number->id}}">{{$number->name}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        @if($number_pair == $number->number)
                                                                                            <option value="{{$number->id}}" selected>{{$number->name}}</option>
                                                                                        @else
                                                                                            <option value="{{$number->id}}">{{$number->name}}</option>
                                                                                        @endif

                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Формат предмета</label>
                                                                            <select class="form-control-sm change-input" name="format_lesson_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($pair_format as $format)
                                                                                    @if(isset($schedule['schedule']))
                                                                                        @if($format->id === $schedule['schedule']->format_id)
                                                                                            <option selected value="{{$format->id}}">{{$format->name}}</option>
                                                                                        @else
                                                                                            <option value="{{$format->id}}">{{$format->name}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option value="{{$format->id}}">{{$format->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Преподаватель</label>
                                                                            <select class="form-control-sm change-input" name="user_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($users as $user)
                                                                                    @if(isset($schedule['schedule']))
                                                                                        @if($user->id === $schedule['schedule']->teacher_id)
                                                                                            <option selected value="{{$user->id}}">{{$user->getFio()}}</option>
                                                                                        @else
                                                                                            <option value="{{$user->id}}">{{$user->getFio()}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option value="{{$user->id}}">{{$user->getFio()}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Время окончания</label>
                                                                            <input class="form-control-sm change-input" name="time_end" type="time" value="{{isset($schedule['schedule'])? $schedule['schedule']->time_end : ''}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Дата начала</label>
                                                                            <input class="form-control-sm change-input" name="date_start" type="date" value="{{isset($schedule['schedule'])? $schedule['schedule']->date_start : (new DateTime($date))->format('Y-m-d')}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Группа</label>
                                                                            <select class="form-control-sm change-input" name="group_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($student_groups as $group)
                                                                                    @if(isset($schedule['schedule']))
                                                                                        @if($group->id === $schedule['schedule']->group_id)
                                                                                            <option selected value="{{$group->id}}">{{$group->number}}</option>
                                                                                        @else
                                                                                            <option value="{{$group->id}}">{{$group->number}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        @if($group_name == $group->number)
                                                                                            <option value="{{$group->id}}" selected>{{$group->number}}</option>
                                                                                        @else
                                                                                            <option value="{{$group->id}}">{{$group->number}}</option>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 d-flex justify-content-center">
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Описание</label>
                                                                            <textarea class="form-control change-input" name="schedule_description">{{isset($schedule['schedule'])? $schedule['schedule']->schedule_description : ''}}</textarea>
                                                                        </div>
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
