<div class="container-duallistbox">
        <div class="form-group duallistbox-select">
            @if($label)
            <label class="m-0">{{$label}}</label>
            @endif
            <select name="{{$name}}" class="duallistbox {{$class}}" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                @foreach($data as  $key=>$val)
                    @if($value && in_array($key, $value))
                        <option value="{{$key}}" selected>{{$val}}</option>
                    @else
                        <option value="{{$key}}">{{$val}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <script>
            $(document).ready(function () {
                //Bootstrap Duallistbox
                $('.duallistbox').bootstrapDualListbox()
            })
        </script>
</div>

