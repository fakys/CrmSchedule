@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{$title}}</div>
            <div class="card-body">
                <form method="POST"
                      @if(isset($semester)) action="{{route('schedule.semester_edit_post', ['semester_id'=>$semester->id])}}"
                      @else action="{{route('schedule.add_semesters_post')}}"
                      @endif
                >
                    @csrf
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" placeholder="Введите номер семестра"
                               title="Введите номер семестра" value="@if(isset($semester)){{$semester->name}}@endif">
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Дата начала</label>
                        <input type="date" class="form-control
                        @error('date_start') is-invalid @enderror" name="date_start"
                               placeholder="Введите дату начала семестра" title="Введите дату начала семестра" value="@if(isset($semester)){{(new DateTime($semester->date_start))->format('Y-m-d')}}@endif">

                        @error('date_start')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Дату окончания</label>
                        <input type="date" class="form-control
                        @error('date_end') is-invalid @enderror" name="date_end"
                               placeholder="Введите дату окончания семестра"
                               title="Введите дату окончания семестра" value="@if(isset($semester)){{(new DateTime($semester->date_end))->format('Y-m-d')}}@endif">

                        @error('date_end')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center"><input type="submit" class="btn-main" @if(isset($semester)) value="Обновить" @else value="Создать" @endif></div>
                </form>
            </div>
        </div>
    </div>
@endsection
