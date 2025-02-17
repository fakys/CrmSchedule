<link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
<script src="{{asset('assets/plugins/js/select2.js')}}"></script>
<script>
    $(document).ready(function (){
        $('.select2').select2()

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<div class="form-group">
    <label>{{$label}}</label>
    <select name="{{$name}}[]" class="form-control select2 {{$class}}" multiple style="width: 100%;">
        @foreach($data as $key=>$val)
            @if(in_array($key, $value))
                <option value="{{$key}}" selected>{{$val}}</option>
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
        @endforeach
    </select>
</div>
