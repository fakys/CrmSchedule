<link rel="stylesheet" href="{{asset('assets/plugins/js_data/css/dataTables.bootstrap4.min.css')}}">
<div class="container">
    <div class="card">
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover" data-url="{{$url}}">
                @csrf
                <thead>
                <tr>
                    @foreach($fields as $field)
                        <th>{{$field}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $val)
                    <tr class="pointer js-table-row" @if(isset($val->id))data-id="{{$val->id}}"@endif>
                        @foreach($val as $field=>$value)
                            @if(in_array($field, array_keys($fields)))
                                <td>{{$value??"Нет данных"}}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="content-tabs-js-table"></div>
        </div>
    </div>
</div>


<script src="{{asset('assets/plugins/js_data/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/js_data/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/js_data/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/js_data/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/js_data/js/js_table.js')}}"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

