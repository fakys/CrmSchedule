@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить студенческую группу</div>
            <div class="card-body">
                <form method="POST" action="{{route('student_groups.add_student_group_post')}}">
                    @csrf
                    <div class="form-group">
                        <label>Номер</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" placeholder="Введите номер группы" title="Введите номер группы">
                        @error('number')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Введите название группы" title="Введите название группы">
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Специальность</label>
                        <select class="form-control" name="specialty">
                            <option value="">Не выбрано</option>
                            @foreach($specialties as $specialty)
                                <option value="{{$specialty->id}}">{{$specialty->name}}</option>
                            @endforeach
                        </select>
                        @error('description')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center"><input type="submit" class="btn-main" value="Создать"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
