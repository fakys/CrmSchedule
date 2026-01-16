<div class="form-group-container">
    <label>{{$label}}</label>
    <select class="form-control" name="{{$name}}">
        @foreach($data as $key=>$val)
            @if($key==$value)
                <option selected value="{{$key}}">{{$val}}</option>
            @else
                <option value="{{$key}}">{{$val}}</option>
            @endif
        @endforeach
    </select>
</div>

