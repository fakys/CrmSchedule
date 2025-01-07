@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить специальность</div>
            <div class="card-body">
                <form method="POST" action="{{route('student_groups.add_specialty_post')}}">
                    @csrf
                    <div class="form-group">
                        <label>Номер</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" placeholder="Введите номер специальности" title="Введите номер специальности">
                        @error('number')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Введите название специальности" title="Введите название специальности">
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"></textarea>
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
