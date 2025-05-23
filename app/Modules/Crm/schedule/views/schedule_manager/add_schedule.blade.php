<?php
/**
 * @var \App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit $unit
 */
?>

<link rel="stylesheet" href="{{asset('assets/css/schedule_style.css')}}">

<div class="btn-save-manager-container">
    <button class="btn-main btn-save-schedule">Сохранить</button>
</div>
@if($use_cash)
    <div id="use_cash" data-url="{{route('schedule.has_schedule_cash_task')}}"></div>
    <div class="alert alert-success d-none" id="cash_alert">
        Расписание кешируется, ожидайте изменений
        <div class="spinner-border spinner-border-sm text-white" role="status"><span class="visually-hidden"></span></div>
    </div>
@endif
<div class="url-edit-schedule" data-url="{{route('schedule.edit_schedule_manager')}}"></div>
<div class="container pt-3">
    <div class="schedule-errors-block"></div>
    @if($schedules)
        @foreach($schedules as $schedule_group_data)
        <div class="schedule-container">
            <div>
                <div class="d-flex mb-2"><div class="semester-name">{{$schedule_group_data['semester_name']}}</div></div>
                @foreach($schedule_group_data['semester_data'] as $group_id => $schedule_group)
                    <div class="card card-primary">
                        <div class="container-header-schedule">
                            <div class="schedule-name-group">{{$schedule_group['group_number']}}</div>

                            <div class="card-tools close-btn-schedule-menu">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="schedule-data-container">
                                @foreach($schedule_group['group_data'] as $date=>$schedule_data)
                                    <div>
                                        <div class="d-flex pb-3">
                                            <div class="schedule-date @if($schedule_data['is_weekday']) schedule-date-weekday @elseif($schedule_data['holiday']) schedule-date-holiday @endif ">{{$date}}</div>
                                            @if($schedule_data['is_weekday'])
                                                <div class="weekday-block"><div class="">Выходной</div></div>
                                            @endif
                                            @if($schedule_data['holiday'])
                                                <div class="holiday-block"><div class="">Праздничный день</div></div>
                                            @endif
                                        </div>
                                        <div class="schedule-pair-data-container">
                                            @foreach($schedule_data['pair_units'] as $unit)
                                                <div class="schedule-block" data-date="{{$unit->getDate()->format('Y-m-d')}}" data-pair_number="{{$unit->getPairNumber()}}" data-student_group="{{$unit->getGroup()}}">
                                                    <div class="d-flex gap-4 schedule-row">
                                                        <div class="schedule-pair-number @if(!$unit->isEmpty()) schedule-pair-number-down @endif">{{$unit->getPairNumber()}}</div>
                                                        <div class="name-subject-container">
                                                            @if(!$unit->isEmpty())
                                                                <div class="d-flex gap-3">
                                                                    <div>{{$unit->getSubjectName()}}</div>
                                                                    <div class="fio-teacher-schedule">{{$unit->getUserFio()}}</div>
                                                                    <div class="time-start-end">{{$unit->getTimeStart()->format('H:i')}} - {{$unit->getTimeEnd()->format('H:i')}}</div>
                                                                </div>
                                                            @else
                                                                @if ($unit->getWeekEnd())
                                                                    <div>
                                                                        Выходной
                                                                    </div>
                                                                @elseif($unit->getHoliday())
                                                                    <div>
                                                                        Праздничный день '{{$unit->getHoliday()->getHolidayName()}}'
                                                                    </div>
                                                                @else
                                                                    <div>
                                                                        Нет данных
                                                                    </div>
                                                                @endif
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
                                                                                    @if($subject->id === $unit->getSubject())
                                                                                        <option selected value="{{$subject->id}}">{{$subject->name}}</option>
                                                                                    @else
                                                                                        <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Время начала</label>
                                                                            <input class="form-control-sm change-input" name="time_start" type="time" value="{{$unit->getTimeStart() ? $unit->getTimeStart()->format("H:i:s") : ''}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Номер пары</label>
                                                                            <select class="form-control-sm change-input" name="pair_number">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($pair_number as $number)
                                                                                    @if($number->number === $unit->getPairNumber())
                                                                                        <option selected value="{{$number->id}}">{{$number->name}}</option>
                                                                                    @else
                                                                                        <option value="{{$number->id}}">{{$number->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Формат предмета</label>
                                                                            <select class="form-control-sm change-input" name="format_lesson_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($pair_format as $format)
                                                                                    @if($format->id === $unit->getFormatPair())
                                                                                        <option selected value="{{$format->id}}">{{$format->name}}</option>
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
                                                                                    @if($user->id === $unit->getUser())
                                                                                        <option selected value="{{$user->id}}">{{$user->getFio()}}</option>
                                                                                    @else
                                                                                        <option value="{{$user->id}}">{{$user->getFio()}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Время окончания</label>
                                                                            <input class="form-control-sm change-input" name="time_end" type="time" value="{{$unit->getTimeEnd() ? $unit->getTimeEnd()->format("H:i:s") : ''}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Дата начала</label>
                                                                            <input class="form-control-sm change-input" name="date_start" type="date" value="{{$unit->getDate()->format("Y-m-d")}}">
                                                                        </div>
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Группа</label>
                                                                            <select class="form-control-sm change-input" name="group_id">
                                                                                <option value="0">Нет данных</option>
                                                                                @foreach($student_groups as $group)
                                                                                    @if($group->id === $unit->getGroup())
                                                                                        <option selected value="{{$group->id}}">{{$group->number}}</option>
                                                                                    @else
                                                                                        <option value="{{$group->id}}">{{$group->number}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 d-flex justify-content-center">
                                                                        <div class="form-group d-flex flex-column">
                                                                            <label>Описание</label>
                                                                            <textarea class="form-control change-input" name="schedule_description">{{$unit->getDescription()}}</textarea>
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
    @else
        <h5>Нет данных</h5>
    @endif
    <script src="{{asset('assets/js/schedule_table.js')}}"></script>
</div>
