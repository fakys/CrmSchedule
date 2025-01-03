@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/select2-bootstrap4.min.css')}}">
@endsection
@section('js_files')
    <script src="{{asset('assets/plugins/js/select2.js')}}"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

<div class="form-group">
    <label>{{$label}}</label>
    <select name="{{$name}}[]" class="form-control select2" multiple style="width: 100%;" >
        @foreach($data as $key=>$val)
        <option value="{{$key}}">{{$val}}</option>
        @endforeach
    </select>
</div>
