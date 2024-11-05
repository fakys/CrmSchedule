<div class="form-group-container">
    @if($value)
        <div class="custom-control custom-switch">
            <input name="{{$name}}" type="checkbox" class="custom-control-input" id="{{$name}}" checked>
            <label class="custom-control-label" for="{{$name}}">{{$label}}</label>
        </div>
    @else
        <div class="custom-control custom-switch">
            <input name="{{$name}}" type="checkbox" class="custom-control-input" id="{{$name}}">
            <label class="custom-control-label" for="{{$name}}">{{$label}}</label>
        </div>
    @endif
</div>

