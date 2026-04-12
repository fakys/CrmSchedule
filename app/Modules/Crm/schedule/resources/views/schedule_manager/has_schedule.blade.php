<?php
/**
 * @var \App\Modules\Crm\schedule\src\schedule_manager\ScheduleUnit $unit
 */
?>

<div id="get_pair_form" data-url="{{ route('schedule.get_pair_form') }}"></div>
<ul class="d-none pair_numbers">
    @foreach($pairs as $pair)
        <li data-number="{{$pair->number}}" data-time-start="{{$pair->time_start}}" data-time-end="{{$pair->time_end}}"></li>
    @endforeach
</ul>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">События расписания</h4>
                    </div>
                    <div class="card-body">
                        <div id="external-events">
                            <div class="external-event bg-success">Выходной день</div>
                            <div class="external-event bg-warning">Каникулы</div>
                            <div class="external-event bg-danger">Карантин</div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Новые пары</h4>
                    </div>
                    <div class="card-body">
                        <div id="external-events-pair">
                            <div class="external-event bg-secondary">Новая пара</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
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
{{$assetsBundleManager->registerFile('app/Modules/Crm/schedule/resources/js/schedule_manager_calendar.js')}}
