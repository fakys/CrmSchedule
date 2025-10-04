<link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
<script src="{{asset('assets/plugins/js/select2.js')}}"></script>

<?php $class_select = rand(1, 999); ?>
<script>
    $(document).ready(function (){
        $('.select_<?=$class_select?>').select2()

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<div class="form-group">
    <label>{{$label}}</label>
    <select name="{{$name}}@if($multiple)[]@endif" class="form-control select_{{$class_select}} {{$class}}" @if($multiple) multiple @endif style="width: 100%;" @if($disabled) disabled @endif>
        @if(!$value && !$multiple)
            <option selected>Не выбрано</option>
        @endif
        @foreach($data as $key=>$val)
            @if($value)
            @if(in_array($key, $value))
                <option value="{{$key}}" selected>{{$val}}</option>
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
        @endforeach
    </select>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>
