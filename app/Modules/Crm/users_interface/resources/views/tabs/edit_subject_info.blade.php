<div class="container">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="h5">Информация о предмете</div>
            </div>
        </div>
        <div class="url-edit-user" data-url="{{route('users_interface.tabs.edit_subject_info_tab')}}"></div>
        <div class="card-body">
            <div class="">
                <div class="row pb-3">
                    <div class="col">Название</div>
                    <div class="col">
                        <div class="edit-form-group">
                            <input class="form-control form-control-sm" name="name" pattern="Название..." value="{{$subject->name}}">
                            <div class="btn btn-success save-btn" data-field="name"><i class="fa fa-check"></i></div>
                        </div>
                        <div class="error-block error-block-last_name"></div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col">Полное название</div>
                    <div class="col">
                        <div class="edit-form-group">
                            <input class="form-control form-control-sm" name="full_name" pattern="Полное название..." value="{{$subject->full_name}}">
                            <div class="btn btn-success save-btn" data-field="full_name"><i class="fa fa-check"></i></div>
                        </div>
                        <div class="error-block error-block-last_name"></div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col">Описание</div>
                    <div class="col">
                        <div class="edit-form-group">
                            <textarea class="form-control form-control-sm" name="description">{{$subject->description}}</textarea>
                            <div>
                                <div class="btn btn-success save-btn" data-field="description"><i class="fa fa-check"></i></div>
                            </div>
                        </div>
                        <div class="error-block error-block-last_name"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{$assetsBundleManager->registerFile('resources/plugins/js/jquery.inputmask.min.js')}}
{{$assetsBundleManager->registerFile('resources/js/tabs/edits/edit_tabs.js')}}
{{$assetsBundleManager->registerFile('resources/plugins/js/moment.min.js')}}
<script>
    $('[data-mask]').inputmask()
</script>
