@foreach($error_schedule as $group_name => $schedule_group_error)
    <div class="schedule-container">
        <div>

                <div class="card card-danger">
                    <div class="container-header-error-schedule">
                        <div class="schedule-name-group">Ошибки валидации в группе {{$group_name}}</div>

                        <div class="card-tools close-btn-schedule-menu">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($schedule_group_error as $date => $error_group)
                            <div class="d-flex mb-3"><div class="error-schedule-date">{{$date}}</div></div>
                            <div class="schedule-data-container">
                                @foreach($error_group as $pair_num=>$error_data)
                                    <div class="error-container-schedule">
                                        <div class="d-flex"><div class="schedule-pair-number-error-block">{{$pair_num}}</div></div>
                                        <div class="schedule-pair-data-container">
                                            <div class="error-schedule-text">{{$error_data}}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>


        </div>
    </div>
@endforeach
