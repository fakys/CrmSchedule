@if($for_settings === 'true' && isset($setting['holidays']))
    @foreach($setting['holidays'] as $number=>$data)
        <div class="card holiday-form" number="{{$number}}" data-number="{{$number}}">
            <div class="card-body">
               <div class="d-flex"><div class="btn btn-danger p-1 pl-2 pr-2 delete-btn ml-auto" data-number="{{$number}}"><i class="fa fa-times" aria-hidden="true"></i></div></div>
                <div class="form-group">
                    <div class="form-group">
                        <label class="p-0">Название праздника</label>
                        <input type="text" class="form-control input-holidays" placeholder="Введите название праздника" name="name" value="{{$data['name']}}">
                    </div>
                    <label>Период праздника</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
                        </div>
                        <input type="text" name="period" class="form-control float-right input-holidays" id="period_{{$number}}" value="{{$data['period']}}">
                    </div>
                </div>
                <div class="form-group d-flex gap-2">
                    <label class="m-0" for="week_end_{{$number}}">Выходные дни</label>
                    <input type="checkbox" @if($data['period']) checked @endif class="form-control-sm week_end input-holidays" id="week_end_{{$number}}" data-number="{{$number}}" name="week_days">
                </div>
                <div class="format_container d-none" id="format_container_{{$number}}">
                    <div class="form-group">
                        <label class="p-0">Формат пар в праздничный день</label>
                        <select class="form-control input-holidays" name="format">
                            @if($data['format'])
                                <option value="0">Нет данных</option>
                                @foreach($format as $f)
                                    @if(in_array($f->id, $data['format']))
                                        <option value="{{$f->id}}" selected>{{$f->name}}</option>
                                    @else
                                        <option value="{{$f->id}}">{{$f->name}}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="0">Нет данных</option>
                                @foreach($format as $f)
                                    <option value="{{$f->id}}">{{$f->name}}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="p-0">Описание праздника</label>
                    <textarea placeholder="Введите описание праздника" class="form-control input-holidays" name="description">{{$data['description']}}</textarea>
                </div>
            </div>
        </div>
        <div class="delete-menu-container" style="display: none" number="{{$number}}">
            <div class="delete-menu">
                <div class="delete-massage">
                    Вы уверенны что хотите удалить праздник "{{$data['name']}}"?
                </div>
                <div class="d-flex">
                    <div class="btn-danger btn menu-btn-delete" data-number="{{$number}}">Удалить</div>
                    <div class="btn-secondary btn ml-3 close-btn-delete" data-number="{{$number}}">Отмена</div>
                </div>
            </div>
        </div>
        <script>
            //Date range picker
            $('#period_{{$number}}').daterangepicker({
                "locale": {
                    "format": "DD.MM.YYYY",
                    "separator": " - ",
                    "applyLabel": "Сохранить",
                    "cancelLabel": "Назад",
                    "daysOfWeek": [
                        "Вс",
                        "Пн",
                        "Вт",
                        "Ср",
                        "Чт",
                        "Пт",
                        "Сб"
                    ],
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    "firstDay": 1,
                }});
        </script>
        <script src="{{asset('assets/modules/holidays/holidays_form.js')}}"></script>
    @endforeach
@else
    <div class="card holiday-form" number="{{$number}}" data-number="{{$number}}">
        <div class="card-body">
            <div class="d-flex"><div class="btn btn-danger p-1 pl-2 pr-2 delete-btn ml-auto" data-number="{{$number}}"><i class="fa fa-times" aria-hidden="true"></i></div></div>
            <div class="form-group">
                <div class="form-group">
                    <label class="p-0">Название праздника</label>
                    <input type="text" class="form-control input-holidays" placeholder="Введите название праздника" name="name">
                </div>
                <label>Период праздника</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
                    </div>
                    <input type="text" name="period" class="form-control float-right input-holidays" id="period_{{$number}}" value="">
                </div>
            </div>
            <div class="form-group d-flex gap-2">
                <label class="m-0" for="week_end_{{$number}}">Выходные дни</label>
                <input type="checkbox" checked class="form-control-sm week_end input-holidays" id="week_end_{{$number}}" data-number="{{$number}}" name="week_days">
            </div>
            <div class="format_container d-none" id="format_container_{{$number}}">
                <div class="form-group">
                    <label class="p-0">Формат пар в праздничный день</label>
                    <select class="form-control input-holidays" name="format">
                        <option value="0">Нет данных</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="p-0">Описание праздника</label>
                <textarea placeholder="Введите описание праздника" class="form-control input-holidays" name="description"></textarea>
            </div>
        </div>
    </div>
    <script>
        //Date range picker
        $('#period_{{$number}}').daterangepicker({
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Сохранить",
                "cancelLabel": "Назад",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1,
            }});
    </script>
    <script src="{{asset('assets/modules/holidays/holidays_form.js')}}"></script>
@endif


