<?php
/**
 * @var \App\Core\Infrastructure\Services\Views\Elements\Div $element
 * @var \App\Core\Application\Services\Views\ViewManagerInterface $viewManager
 */
?>

<div
    <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
        id="<?= $element->getAdditionalParams()->getElementId() ?>"
    <?php endif; ?>
    <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
        class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
    <?php endif; ?>
>
    <?php foreach ($element->getElements() as $elem): ?>
        <?= $viewManager->renderElement($elem) ?>
    <?php endforeach;?>
</div>
