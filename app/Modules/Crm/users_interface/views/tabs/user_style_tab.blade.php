<div id="save_style" data-url="{{route('users_interface.tabs.set_user_style_tab')}}"></div>

<div class="container">
    <div class="form-group">
        <input type="color" class="form-control" name="user_color" id="user_color" @if($style) value="{{$style->user_color}}" @endif>
    </div>
    <div class="d-flex"><div class="btn-main" id="btn_save">Сохранить</div></div>
</div>

<script src="{{asset('assets/js/tabs/edits/user_style_tabs.js')}}"></script>
