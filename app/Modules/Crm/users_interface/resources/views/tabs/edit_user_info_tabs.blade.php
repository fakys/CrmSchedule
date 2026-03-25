<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о пользователе</div>
            </div>
        </div>
        <div class="url-edit-user" data-url="{{route('users_interface.tabs.set_edit_user_tabs')}}"></div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    Общая информация
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Фамилия</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="last_name" pattern="Фамилия..." value="{{$data['info']->last_name}}">
                                <div class="btn btn-success save-btn" data-field="last_name"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-last_name"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Имя</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="first_name" pattern="Имя..." value="{{$data['info']->first_name}}">
                                <div class="btn btn-success save-btn" data-field="first_name"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-first_name"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Отчество</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="patronymic" pattern="Отчество..." value="{{$data['info']->patronymic}}">
                                <div class="btn btn-success save-btn" data-field="patronymic"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-patronymic"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Email</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="email" pattern="Email..." value="{{$data['info']->email}}">
                                <div class="btn btn-success save-btn" data-field="email"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-email"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер телефона</div>
                        <div class="col">
                            <div class="edit-form-group">
                                +7
                                <input type="text" class="form-control form-control-sm" name="number_phone" pattern="Номер телефона..." data-inputmask="'mask': ['999-999-9999', '+7 999-999-9999']"
                                       data-mask="" inputmode="text" value="{{$data['info']->number_phone}}">
                                <div class="btn btn-success save-btn" data-field="number_phone"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-number_phone"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Дата рождения</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input type="text" class="form-control form-control-sm" name="birthday" pattern="Дата рождения..." data-inputmask-alias="datetime"
                                       data-inputmask-inputformat="dd.mm.yyyy" data-mask=""
                                       inputmode="numeric" value="{{isset($data['info']->birthday)?(new DateTime($data['info']->birthday))->format('dmY'):''}}">
                                <div class="btn btn-success save-btn"  data-field="birthday"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-birthday"></div>
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
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="inn" pattern="ИНН..." type="number" value="{{$data['documents']->inn}}">
                                <div class="btn btn-success save-btn" data-field="inn"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-inn"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Серия</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="passport_series" pattern="Серия..." type="number" value="{{$data['documents']->passport_series}}">
                                <div class="btn btn-success save-btn" data-field="passport_series"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-passport_series"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="passport_number" type="number" pattern="Номер..." value="{{$data['documents']->passport_number}}">
                                <div class="btn btn-success save-btn" data-field="passport_number"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-passport_number"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">СНИЛС</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="snils" pattern="СНИЛС..." value="{{$data['documents']->snils}}">
                                <div class="btn btn-success save-btn" data-field="snils"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-snils"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Адрес</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <textarea class="form-control" rows="3" name="address" placeholder="Адрес ...">{{$data['documents']->address}}</textarea>
                                <div><div class="btn btn-success save-btn" data-field="address"><i class="fa fa-check"></i></div></div>
                            </div>
                            <div class="error-block error-block-address"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('assets/js/tabs/edits/user_info.js')}}"></script>
<script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
<script>
    $('[data-mask]').inputmask()
</script>
