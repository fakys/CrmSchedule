@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/plugins/js_data/css/dataTables.bootstrap4.min.css')}}">
@endsection
<div class="container">
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
            @foreach($fields as $field)
                <th>{{$field}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            @foreach($data as $val)
                <tr>
                    @foreach($val as $field=>$value)
                        @if(isset($fields[$field]))
                            <td>{{$value}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('js_files')
    <script src="{{asset('assets/plugins/js_data/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js_data/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js_data/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/js_data/js/dataTables.buttons.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
