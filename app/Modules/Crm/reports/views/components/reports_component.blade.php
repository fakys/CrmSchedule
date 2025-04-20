<script>
    var required_fields = <?=json_encode($required_fields)?>;
    var task_name = '{{$task_name}}'
</script>
<div class="pl-5 pr-5">
    <div class="card">
        <div class="card-body table-container">
            <table class="table table-bordered table-hover crm-table">
                <thead>
                <tr>
                    <div class="d-flex">
                        <div>
                            <select class="form-control-sm mb-2">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="ml-auto d-flex align-items-center gap-2">
                            <button class="btn-main" id="export_btn"><i class="fa fa-file" aria-hidden="true"></i> Экспорт в excel</button>
                            <button class="btn-main" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i> Поиск</button>
                        </div>
                    </div>
                </tr>
                <tr>
                    @foreach($fields as $name=>$label)
                        <th scope="col" data-column="{{$name}}">
                            <div class="row-container">
                                {{$label}}
                                <div class="sort-table"><i class="fa fa-sort" aria-hidden="true"></i></div>
                            </div>
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        @foreach($row as $col_name => $col)
                            @if(isset($fields[$col_name]))
                            <th>
                                {{$col}}
                            </th>
                            @endif
                        @endforeach
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
