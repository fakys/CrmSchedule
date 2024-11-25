<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о пользователе</div>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    Общая информация
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Фамилия</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="Фамилия..." value="{{$data['info']->last_name}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Имя</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="Имя..." value="{{$data['info']->first_name}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Отчество</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="Отчество..." value="{{$data['info']->patronymic}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Email</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="Email..." value="{{$data['info']->email}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер телефона</div>
                        <div class="col edit-form-group">
                            <input type="text" class="form-control form-control-sm" pattern="Номер телефона..." data-inputmask="'mask': ['999-999-9999', '+7 999-999-9999']"
                                   data-mask="" inputmode="text" value="{{$data['info']->number_phone}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>

                    </div>
                    <div class="row pb-3">
                        <div class="col">Дата рождения</div>
                        <div class="col edit-form-group">
                            <input type="text" class="form-control form-control-sm" pattern="Дата рождения..." data-inputmask-alias="datetime"
                                   data-inputmask-inputformat="dd.mm.yyyy" data-mask=""
                                   inputmode="numeric" value="{{isset($data['info']->brichday)?date('d.m.Y', $data['info']->brichday):""}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Документы
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">ИНН</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="ИНН..." type="number" value="{{$data['documents']->inn}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Серия</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="Серия..." type="number" value="{{$data['documents']->pssport_series}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" type="number" pattern="Номер..." value="{{$data['documents']->pssport_number}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">СНИЛС</div>
                        <div class="col edit-form-group">
                            <input class="form-control form-control-sm" pattern="СНИЛС..." value="{{$data['documents']->snils}}">
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Адрес</div>
                        <div class="col edit-form-group">
                            <textarea class="form-control" rows="3" placeholder="Адрес ...">{{$data['documents']->address}}</textarea>
                            <div class="btn btn-success save-btn"><i class="fa fa-check"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
<script>
    $('[data-mask]').inputmask()
</script>
