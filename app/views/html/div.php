<?php
/**
 * @var \App\Services\Views\Infrastructure\Services\Elements\DivElement $element
 * @var ViewManagerInterface $viewManager
 */

use App\Services\Views\Domain\Services\ViewManagerInterface;

?>

<div
    <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
        id="<?= $element->getAdditionalParams()->getElementId() ?>"
    <?php endif; ?>
    <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
        class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
    <?php endif; ?>
>
    <?php if ($element->getText()): ?>
        <?= $element->getText() ?>
    <?php endif; ?>
    <?php foreach ($element->getElements() as $elem): ?>
        <?= $viewManager->renderElement($elem) ?>
    <?php endforeach;?>
</div>
