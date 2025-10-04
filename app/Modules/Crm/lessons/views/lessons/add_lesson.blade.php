@extends("layout::base_layout")



@section('content')
<div class="container">
    <form method="post" action="{{route('lessons.set_lesson')}}">
        @csrf
        {{\App\Src\Html\Html::select_search('Преподаватель', 'teacher', $teachers, [], '', false)}}
        {{\App\Src\Html\Html::select_search('Предмет', 'subject', $subjects, [], '', false)}}
        <div> <button class="btn-main" type="submit">Сохранить</button></div>
    </form>
</div>
@endsection
