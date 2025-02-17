<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о группе и специальности</div>
            </div>
        </div>
        <div class="url-edit-user" data-url="{{route('users_interface.tabs.set_edit_student_groups')}}"></div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    Информация о группе
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="groups-number" pattern="Номер..." value="{{$user_group->number}}">
                                <div class="btn btn-success save-btn" data-field="groups-number"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-last_name"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Название</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="groups-name" pattern="Название..." value="{{$user_group->name}}">
                                <div class="btn btn-success save-btn" data-field="groups-name"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-last_name"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Cпециальность
                </div>
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col">Номер</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="specialty-number" pattern="ИНН..." type="text" value="{{$specialty->number}}">
                                <div class="btn btn-success save-btn" data-field="specialty-number"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-inn"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Название</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <input class="form-control form-control-sm" name="specialty-name" pattern="Серия..." type="text" value="{{$specialty->name}}">
                                <div class="btn btn-success save-btn" data-field="specialty-name"><i class="fa fa-check"></i></div>
                            </div>
                            <div class="error-block error-block-passport_series"></div>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col">Описание</div>
                        <div class="col">
                            <div class="edit-form-group">
                                <textarea class="form-control form-control-sm" name="specialty-description" pattern="Описание...">{{$specialty->description}}</textarea>
                                <div><div class="btn btn-success save-btn" data-field="specialty-description"><i class="fa fa-check"></i></div></div>
                            </div>
                            <div class="error-block error-block-passport_number"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/plugins/js/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('assets/js/tabs/edits/student_groups.js')}}"></script>
<script src="{{asset('assets/plugins/js/moment.min.js')}}"></script>
<script>
    $('[data-mask]').inputmask()
</script>
