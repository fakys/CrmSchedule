@extends("layout::base_layout")

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Добавить предмет</div>
            <div class="card-body">
                <form method="POST" action="{{route('lessons.add_subject')}}">
                    @csrf
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Введите название предмета" title="Введите название предмета">
                        @error('name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Полное название</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" placeholder="Введите полное название предмета" title="Введите полное название предмета">
                        @error('full_name')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Введите описание" title="Введите описание"></textarea>
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
