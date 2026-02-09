<link rel="stylesheet" href="{{asset('assets/plugins/js_data/css/dataTables.bootstrap4.min.css')}}">
@vite([
    'resources/plugins/js_data/js/jquery.dataTables.min.js',
    'resources/plugins/js_data/js/dataTables.bootstrap4.min.js',
    'resources/plugins/js_data/js/dataTables.buttons.min.js',
    'resources/plugins/js_data/js/js_table.js',
    'resources/plugins/js_data/js/datatables-init.js',
    ])

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
