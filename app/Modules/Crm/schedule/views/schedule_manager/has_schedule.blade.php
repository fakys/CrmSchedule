<?php
/**
 * @var \App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit $unit
 */
?>

<link rel="stylesheet" href="{{asset('assets/css/schedule_style.css')}}">

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
</div>
