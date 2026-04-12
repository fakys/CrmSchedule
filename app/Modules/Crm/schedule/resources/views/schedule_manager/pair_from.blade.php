<?php
/**
 * @var \App\Services\Views\Infrastructure\Services\ViewManager $viewManager
 */
?>

<div>
    {{$assetsBundleManager->registerHeaderFiles()}}
    <div id="card_id_pair_form" data-id="{{$id}}"></div>
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
</div>
