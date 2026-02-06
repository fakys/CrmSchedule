@extends("layout::base_layout")

@section('css_files')
    <link rel="stylesheet" href="{{asset('assets/css/schedule_plan.css')}}">
@endsection

@section('js_files')
    <script src="{{asset('assets/js/add_schedule_plan.js')}}"></script>
@endsection

@section('content')
    @csrf
    <div class="container">
        <div id="delete_session" data-url="{{route('schedule_plan.delete_session')}}"></div>
        <div id="get_group" data-url="{{route('schedule_plan.get_group_input')}}"></div>
        <div id="check_schedule_plan" data-url="{{route('schedule_plan.check_schedule_plan')}}"></div>
        <div id="get_constructor_schedule" data-url="{{route('schedule_plan.get_constructor_schedule')}}"></div>
        <div class="card">
            <div class="card-header">
                <div class="title-schedule-plan">Добавить плана расписания</div>
            </div>
            <div class="card-body">
                <div>
                    @error('file_error')
                    <div class="error">
                        <div style="font-size: 18px">Ошибки в загруженном файле: </div>
                        <ul>
                            <li>{{$message}}</li>
                        </ul>

                    </div>
                    @enderror
                    @if($cash_data)<div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Удалить сессию
                        </button>
                    </div>@endif
                    <div class="form-group">
                        <label>Семестр</label>
                        <select class="semester-select form-control" name="semester" id="select_semester_schedule_plan" @if($cash_data) disabled @endif>
                            @foreach($semesters as $semester)
                                @if($cash_data && $semester->id == $cash_data['semester'])
                                    <option value="{{$semester->id}}" selected>{{$semester->name}} {{$semester->year_start}}-{{$semester->year_end}}</option>
                                @else
                                    <option value="{{$semester->id}}">{{$semester->name}} {{$semester->year_start}}-{{$semester->year_end}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    {{\App\Src\Html\Html::select_search('Специальность', 'specialties', $specialties,
                       $cash_data ?(is_array($cash_data['specialties'])?$cash_data['specialties']:[$cash_data['specialties']]):[],
                     'specialties_select', false, false,  $cash_data)}}
                    <div class="select_group_container">

                    </div>
                    <div id="schedule_plan_type">

                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div>
                        <div class="btn btn-main" id="add_plan_schedule">Составить расписание на семестр</div>
                    </div>
                </div>
                <div class="pt-5">
                    <div id="constructor_schedule"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="deleteSessionModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Вы уверены что хотите удалить сессию?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Данные которые вы заполняли исчезнут навсегда
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <div class="btn btn-danger delete_session">Удалить</div>
                </div>
            </div>
        </div>
    </div>
@endsection
