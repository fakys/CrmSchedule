@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{$title}}</div>
            <div class="card-body">
                <form method="POST" action="{{isset($number_pair)?route('lessons.update_pair_number', ['id'=>$number_pair->id]):route('lessons.add_pair_number')}}">
                    @csrf
                    <div class="form-group">
                        <label>Номер</label>
                        <input type="number" min="0" class="form-control @error('number') is-invalid @enderror" name="number" placeholder="Введите номер пары" title="Введите номер пары" value="{{isset($number_pair)?$number_pair->number:''}}">
                        @error('number')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Введите название последовательности пары" title="Введите название последовательности пары" value="{{isset($number_pair)?$number_pair->name:''}}">
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (isset($number_pair))
                        <div class="d-flex justify-content-center"><input type="submit" class="btn-main" value="Обновить"></div>
                    @else
                        <div class="d-flex justify-content-center"><input type="submit" class="btn-main" value="Создать"></div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
