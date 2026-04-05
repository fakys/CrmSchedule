<?php
/**
 * @var \App\Services\Views\Infrastructure\Services\ViewManager $viewManager
 */
?>

<div>
    {{$assetsBundleManager->registerHeaderFiles()}}
    <div id="card_id_pair_form" data-card-id="{{$card_id}}"></div>
    {{$viewManager->renderElement($viewManager->getElementByTag('form')->startForm())}}
    @if($viewManager->getElementByTag('form')->hasElement('teacherId'))
        {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('teacherId'))}}
    @endif
    <div class="subject-input-container">
        @if($viewManager->getElementByTag('form')->hasElement('subjectId'))
            {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('subjectId'))}}
        @endif
    </div>
    @if($viewManager->getElementByTag('form')->hasElement('timeStart'))
        {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('timeStart'))}}
    @endif
    @if($viewManager->getElementByTag('form')->hasElement('timeEnd'))
        {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('timeEnd'))}}
    @endif
    @if($viewManager->getElementByTag('form')->hasElement('formatId'))
        {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('formatId'))}}
    @endif
    @if($viewManager->getElementByTag('form')->hasElement('description'))
        {{$viewManager->renderElement($viewManager->getElementByTag('form')->getElementByTag('description'))}}
    @endif
    {{$viewManager->renderElement($viewManager->getElementByTag('form')->endForm())}}
    {{$assetsBundleManager->registerBodyFiles()}}
{{--    <form>--}}
{{--        --}}
{{--        {{$viewManager->renderElementByTag('user')}}--}}
{{--        <div class="subject-input-container">--}}
{{--            @if($subject)--}}
{{--                {{$viewManager->renderElementByTag('subject')}}--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {{$viewManager->renderElementByTag('format')}}--}}
{{--        <div class="form-group">--}}
{{--            <label>Время начала</label>--}}
{{--            <input class="form-control-sm schedule-input" name="time_start" type="time" value="{{$data['time_start']??null}}">--}}
{{--            <div class="error-block"></div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label>Время окончания</label>--}}
{{--            <input class="form-control-sm schedule-input" name="time_end" type="time" value="{{$data['time_end']??null}}">--}}
{{--            <div class="error-block"></div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label class="p-0">Описание расписания</label>--}}
{{--            <textarea class="form-control schedule-input" name="description">{{$data['description']??null}}</textarea>--}}
{{--            <div class="error-block"></div>--}}
{{--        </div>--}}
{{--    </form>--}}
</div>
