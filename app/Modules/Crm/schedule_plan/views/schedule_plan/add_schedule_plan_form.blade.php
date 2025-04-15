<?php /** @var \App\Modules\Crm\schedule_plan\src\SchedulePlanEntity $schedule_plan_data */?>
<script>
    let is_success_schedule = <?=($schedule_plan_data->getScheduleUnits())?'true':'false'?>;
</script>
<div class="card">
    <div class="card-header">
        Создание плана расписания
    </div>
    <div class="card-body">
        <div id="add_url_schedule_plan" data-url="{{route('schedule_plan.save_schedule_plan')}}"></div>
        <div class="d-flex mb-4"><div class="btn-main save-plan_schedule">Создать</div></div>
        @foreach($weeks as $number_week=>$week)
            <div class="week_number">Неделя <b>№{{$number_week}}</b></div>
            <div class="week-container" data-number_week="{{$number_week}}">
                @foreach($week['week_end'] as $day_week_number=>$week_end)
                    <div class="week-day-container">
                        <div>
                            <div class="week-day-name @if($week_end != 'false') week-end-name @endif">{{$week_days[$day_week_number]}}</div>
                        </div>
                        @foreach($pair_number as $pair)
                            <?php
                                $pair_data = $schedule_plan_data->getScheduleUnitByData($number_week, $day_week_number, $pair->id);
                                ?>
                            <div class="card mt-3 collapsed-card">
                                <div class="card-header pair-number-container">
                                    <div class="card-title d-flex"><div>{{$pair->number}} пара</div>
                                        <div class="before-success-day-plan before-success-day-plan-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"  @if(!$pair_data) style="display: none" @endif >Заполнено ранее</div>
                                        <div class="success-day-plan success-day-plan-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"  style="display: none" >Заполнено</div>
                                        <div class="edit-day-plan edit-day-plan-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}" style="display: none">Изменено</div>
                                        <div class="week-end-day-plan week-end-day-plan-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}" style="display: none">Свободная</div>
                                    </div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: none">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group d-flex flex-column">
                                                <label>Предмет</label>
                                                <select
                                                    class="form-control-sm input-data required-input required-input-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"
                                                    name="subject_id"
                                                    data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                    data-pair_number="{{$pair->number}}">
                                                    <option value="0">Нет данных</option>
                                                    @foreach($subjects as $subject)}
                                                        @if($pair_data && $pair_data->getSubject() == $subject->id)
                                                            <option value="{{$subject->id}}" selected>{{$subject->name}}</option>
                                                        @else
                                                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group d-flex flex-column">
                                                <label>Время начала</label>
                                                <input
                                                    class="form-control-sm input-data required-input required-input-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"
                                                    name="time_start" type="time" value="{{isset($pair_data)?$pair_data->getTimeStart():''}}"
                                                    data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                    data-pair_number="{{$pair->number}}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group d-flex flex-column">
                                                <label>Преподаватель</label>
                                                <select
                                                    class="form-control-sm input-data required-input required-input-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"
                                                    name="user_id"
                                                    data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                    data-pair_number="{{$pair->number}}">
                                                    <option value="0">Нет данных</option>
                                                    @foreach($users as $user)
                                                        @if($pair_data && $pair_data->getUser() == $user->id)
                                                            <option value="{{$user->id}}" selected>{{$user->getFio()}}</option>
                                                        @else
                                                            <option value="{{$user->id}}">{{$user->getFio()}}</option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group d-flex flex-column">
                                                <label>Время окончания</label>
                                                <input
                                                    class="form-control-sm input-data required-input required-input-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"
                                                    name="time_end" type="time" value="{{isset($pair_data)?$pair_data->getTimeEnd():''}}"
                                                    data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                    data-pair_number="{{$pair->number}}">
                                            </div>
                                            <div class="form-group d-flex flex-column">
                                                <label>Формат предмета</label>
                                                <select
                                                    class="form-control-sm input-data required-input required-input-{{$number_week}}-{{$day_week_number}}-{{$pair->number}}"
                                                    name="format_lesson_id"
                                                    data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                    data-pair_number="{{$pair->number}}">
                                                    <option value="0">Нет данных</option>
                                                    @foreach($pair_format as $format)
                                                        @if($pair_data && $pair_data->getFormatPair() == $format->id)
                                                            <option value="{{$format->id}}" selected>{{$format->name}}</option>
                                                        @else
                                                            <option value="{{$format->id}}">{{$format->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="form-group d-flex flex-column">
                                                <label>Описание</label>
                                                <textarea class="form-control change-input input-data" name="schedule_description"
                                                          data-number_week="{{$number_week}}" data-day_week_number="{{$day_week_number}}"
                                                          data-pair_number="{{$pair->number}}"
                                                >{{isset($pair_data)?$pair_data->getDescription():''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>
            <hr/>
        @endforeach
    </div>
</div>
<script src="{{asset('assets/js/schedule_plan.js')}}"></script>
