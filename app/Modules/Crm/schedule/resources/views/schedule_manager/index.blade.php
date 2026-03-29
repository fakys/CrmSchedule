@extends("layout::base_layout")

@section('content')
    @csrf
    <div class="d-none url-manager-menu" data-url="{{route('schedule.schedule_manager_menu')}}"></div>
    <div class="card">
        <div class="card-header">
            {{$title}}
        </div>
        <div class="card-body">
            {{$viewManager->renderElementByTag('period')}}
            {{$viewManager->renderElementByTag('groups')}}
            {{$viewManager->renderElementByTag('specialties')}}
            <div class="form-group">
                <button class="btn-main" id="btn_search_manager">Найти</button>
            </div>
        </div>
        <div>
            <div class="schedule-manager-menu"></div>
        </div>
    </div>
@endsection
