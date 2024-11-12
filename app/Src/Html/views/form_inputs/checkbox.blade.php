<div class="form-group-container">
    <div class="custom-control custom-switch">
        <input name="{{$name}}" type="checkbox" class="custom-control-input {{$class}}" id="{{$name}}" @if($value) checked @endif>
        <label class="custom-control-label" for="{{$name}}">{{$label}}</label>
    </div>
</div>

