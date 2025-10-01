<?php
/**
 * @var \App\Entity\PairNumber[] $pairs
 */
?>
<div id="get_form_for_pair" data-url="{{ route('schedule_plan.get_form_for_pair') }}"></div>
<div id="set_schedule_plan_cash" data-url="{{ route('schedule_plan.set_schedule_plan_cash') }}"></div>
<div id="get_new_card_name" data-url="{{ route('schedule_plan.get_new_card_name') }}"></div>
<div id="validate_card" data-url="{{ route('schedule_plan.validate_card') }}"></div>
<div class="container_construct_schedule">
    <div class="construct_schedule_header">
        <div class="d-flex">
            <div class="btn-main save-plan_schedule">Сохранить</div>
            <div class="btn-open-construct ml-3" data-status="close">
                <i class="fas fa-expand-arrows-alt"></i>
            </div>
        </div>
    </div>

    <div class="row_construct_schedule">
        <div>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div class="schedule_dashboard_container">
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
                                    @foreach($week['week_end'] as $day => $week_end)
                                        <div class="day-container">
                                            <div class="day-header">
                                                <div>{{ $week_days[$day+1] }}</div>
                                                <div class="add_card">{{'Добавить'}}</div>
                                            </div>
                                            @foreach($pairs as $number_pair)
                                                <div class="pair-number-cont" >
                                                    <div class="pair-number">{{$number_pair->name}}</div>
                                                </div>
                                                <div class="card-slot connectedSortable ui-sortable" data-week_day="{{$day}}" data-number="{{$number_pair->number}}" data-week_number="{{$key}}" data-group="{{$group->id}}">
                                                    @if($cash_data)
                                                        @foreach($cash_data['schedule_data'] as $card)
                                                            @if($card['weekDay']==$day && $number_pair->number == $card['numberPair'] && $card['weekNumber']==$key && $card['group'] == $group->id)
                                                                    <?php $count += 1; ?>
                                                                <div
                                                                    data-week_day="{{$day}}" data-number="{{$number_pair->number}}"
                                                                    data-week_number="{{$key}}" card_id="{{$count}}"
                                                                    data-subject="{{$card['subject']}}"
                                                                    data-user="{{$card['user']}}"
{{--                                                                    Все тут импользуется чисто при загрузке--}}
                                                                    data-time_start="{{$card['time_start']??null}}" data-time_end="{{$card['time_end']??null}}"
                                                                    data-description="{{$card['description']??null}}" data-group="{{$card['group']??null}}"
                                                                    @if(isset($card['user'])) <?php $style = \App\Src\BackendHelper::getRepositories()->getStyleByUserId($card['user']);?> style="background: {{$style?$style->user_color:''}};" @endif
                                                                    class="pair-card pair-empty card mb-2 text-white @if(empty($card['user'])) bg-gradient-secondary @endif">
                                                                    <div class="card-header border-0 ui-sortable-handle"
                                                                         style="cursor: move;">
                                                                        <h3 class="card-pair-title">
                                                                            <i class="fa fa-users"
                                                                               aria-hidden="true"></i>
                                                                            <div class="card-name">
                                                                                {{$card['cardName']}}
                                                                            </div>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="card-body-pair" data-bs-toggle="modal"
                                                                         data-bs-target="#card_model_data">
                                                                        <div class='card_time'>
                                                                            {{sprintf('%s - %s', $card['time_start']??null, $card['time_end']??null)}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-footer d-flex justify-content-center"><div class="btn btn-danger delete-card">Удалить карточку</div></div>
                                                                </div>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>
                                    @endforeach
                                </div>

                            @endforeach

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

<script src="{{ asset('assets/plugins/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/construct_schedule.js') }}"></script>

