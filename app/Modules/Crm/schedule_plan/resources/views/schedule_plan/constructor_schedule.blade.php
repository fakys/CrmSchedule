<?php
/**
 * @var \App\Entity\PairNumber[] $pairs
 * @var \App\Modules\Crm\schedule_plan\src\SchedulePlanReturnData $schedule_data
 */
?>


<div id="get_subject_input" data-url="{{ route('schedule_plan.get_subject_input') }}"></div>
<div id="get_form_for_pair" data-url="{{ route('schedule_plan.get_form_for_pair') }}"></div>
<div id="set_plan_schedule" data-url="{{ route('schedule_plan.set_plan_schedule') }}"></div>
<div id="download_template_url" data-url="{{ route('schedule_plan.download_template') }}"></div>
<div id="set_schedule_plan_cash" data-url="{{ route('schedule_plan.set_schedule_plan_cash') }}"></div>
<div id="get_new_card_name" data-url="{{ route('schedule_plan.get_new_card_name') }}"></div>
<div id="validate_card" data-url="{{ route('schedule_plan.validate_card') }}"></div>
<div id="download_schedule_file" data-url="{{route('schedule_plan.download_schedule_file')}}"></div>
<div id="check_status_schedule_plan_cron" data-url="{{route('schedule_plan.check_status_schedule_plan_cron')}}"></div>
<div id="check_status_save_schedule_plan_task" data-url="{{route('schedule_plan.check_status_save_schedule_plan_task')}}"></div>

<ul class="d-none pair_numbers">
    @foreach($pairs as $pair)
        <li data-number="{{$pair->number}}" data-time-start="{{$pair->time_start}}" data-time-end="{{$pair->time_end}}"></li>
    @endforeach
</ul>
<div class="container_construct_schedule">
    <div class="construct_schedule_header">
        <div class="d-flex">
            <div class="btn-main save-plan_schedule">Сохранить</div>
            <div class="btn-open-construct ml-3" data-status="close">
                <i class="fas fa-expand-arrows-alt"></i>
            </div>
        </div>
    </div>

    @if($schedule_data->getErrorMessage())
        <div class="alert alert-danger mt-3" id="ErrorAlert">
            <strong>{{$schedule_data->getErrorMessage()}}</strong>
        </div>
    @endif

    <div class="row_construct_schedule">
        <div>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div class="schedule_dashboard_container">
            <div>
                <div>
                    <label>Загрузить расписание через Excel:</label>
                    <div class="d-flex gap-3 align-items-center">
                        <input type="file" name="file" class="form-control" id="download_schedule_file_input" style="width: 300px">
                        <div class="">
                            <button class="btn btn-secondary" id="download_schedule_file_btn">
                                Загрузить
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php $count = 0; ?>
            @foreach($data as $group)
                <div class="schedule_dashboard">
                    <div class="dashboard_column card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white">{{ $group->name }}</h3>
                        </div>
                        <div class="card-body p-0">
                            @foreach($plan->getWeeks() as $key => $week)
                                <div class="dashboard_column card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ 'Неделя №'.$key }}</h3>
                                    </div>
                                    <div class="week-content">
                                        <div class="pair-numbers">
                                            <div class="pair-numbers-fix">
                                                @foreach($pairs as $number_pair)
                                                    <div class="pair-number">№{{$number_pair->number}}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="days-container">
                                            @foreach($week['week_end'] as $day => $week_end)
                                                <div class="day-container">
                                                    <div class="day-header">
                                                        {{ $week_days[$day+1] }}
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </div>
                                                    @foreach($pairs as $number_pair)
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="card-slot connectedSortable ui-sortable" data-week-day="{{$day}}" data-number="{{$number_pair->number}}" data-week-number="{{$key}}" data-group-id="{{$group->id}}">
                                                                @if($schedule_data)
                                                                    @foreach($schedule_data->getScheduleData() as $card)
                                                                        @if($card['weekDay']==$day && $number_pair->number == $card['numberPair'] && $card['weekNumber']==$key && $card['groupId'] == $group->id)
                                                                                <?php $count += 1; ?>
                                                                            <div
                                                                                data-week-day="{{$day}}" data-number-pair="{{$number_pair->number}}"
                                                                                data-week-number="{{$key}}" data-card-id="{{$count}}"
                                                                                data-subject-id="{{$card['subjectId']}}"
                                                                                data-teacher-id="{{$card['teacherId']}}"
                                                                                {{--                                                                    Все тут импользуется чисто при загрузке--}}
                                                                                data-time-start="{{$card['timeStart']??null}}" data-time-end="{{$card['timeEnd']??null}}"
                                                                                data-description="{{$card['description']??null}}" data-group-id="{{$card['groupId']??null}}"
                                                                                data-format-id="{{$card['formatId']??null}}"
                                                                                data-error-message="{{$card['errorMessage']}}"
                                                                                @if(isset($card['teacherId'])) style="background: {{$all_users_style[$card['teacherId']]??''}};" @endif
                                                                                class="pair-card pair-empty @if($card['errorMessage']) cardError @endif card mb-2 text-white @if(empty($card['teacherId'])) bg-gradient-secondary @endif">
                                                                                <div class="card-header border-0 ui-sortable-handle"
                                                                                     style="cursor: move;">
                                                                                    <h3 class="card-pair-title">
                                                                                        <i class="fa fa-users"
                                                                                           aria-hidden="true"></i>
                                                                                        <div class="card-name">
                                                                                            {{$card['cardName']??''}}
                                                                                        </div>
                                                                                    </h3>
                                                                                </div>
                                                                                <div class="card-body-pair" data-bs-toggle="modal"
                                                                                     data-bs-target="#card_model_data">
                                                                                    <div class='card_time'>
                                                                                        {{sprintf('%s - %s', $card['timeStart']??null, $card['timeEnd']??null)}}
                                                                                    </div>
                                                                                    @if($card['errorMessage'])
                                                                                        <div class="error-text-card">
                                                                                            {{$card['errorMessage']}}
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="card_model_data" tabindex="-1" aria-labelledby="card_model_data_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="card_model_data_label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa fa-times" aria-hidden="true" style="color: black"></i></button>
            </div>
            <div class="modal-body" id="card_modal_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Назад</button>
                <button type="button" class="btn btn-primary btn_save_schedule">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>
<div id="context-menu" class="custom-context-menu">

</div>
{{$assetsBundleManager->registerFile('resources/plugins/js/jquery-ui.min.js')}}
{{$assetsBundleManager->registerFile('resources/plugins/js/dashboard.js')}}
{{$assetsBundleManager->registerFile('app/Modules/Crm/schedule_plan/resources/js/construct_schedule.js')}}

