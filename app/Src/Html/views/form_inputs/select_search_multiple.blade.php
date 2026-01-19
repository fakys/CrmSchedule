<div class="container-duallistbox">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/bootstrap-duallistbox.min.css')}}">

        <div class="form-group duallistbox-select">
            @if($label)
            <label class="m-0">{{$label}}</label>
            @endif
            <select name="{{$name}}" class="duallistbox {{$class}}" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                @foreach($data as  $key=>$val)
                    @if(in_array($key, $value))
                        <option value="{{$key}}" selected>{{$val}}</option>
                    @else
                        <option value="{{$key}}">{{$val}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <script src="{{asset('assets/plugins/js/jquery.bootstrap-duallistbox.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                //Bootstrap Duallistbox
                $('.duallistbox').bootstrapDualListbox()
            })

        </script>
</div>

