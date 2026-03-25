<?php
/**
 * @var \App\Services\Forms\Infrastructure\Services\FormElement\Form\FormHeaderElement $element
 * @var ViewManagerInterface $viewManager
 */

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;

?>

<form method="<?= $element->getForm()->getAdditionalParams()->getMethod() ?>"
    <?php if ($element->getForm()->getAdditionalParams()->getElementId()): ?>
        id="<?= $element->getForm()->getAdditionalParams()->getElementId() ?>"
    <?php else: ?>
        id="<?= $element->getForm()->getTag() ?>"
    <?php endif; ?>
    <?php if ($element->getForm()->getAdditionalParams() && $element->getForm()->getAdditionalParams()->getElementClasses()): ?>
        class="<?= implode(' ', $element->getForm()->getAdditionalParams()->getElementClasses()) ?>"
    <?php endif; ?>
    <?php if($element->getForm()->getAdditionalParams()->getUrl()): ?> action="<?=$element->getForm()->getAdditionalParams()->getUrl()?>" <?php endif; ?>
>
    <div class="validate-js-name"
        <?php if ($element->getForm()->getAdditionalParams()->getElementId()): ?>
            data-form="<?= $element->getForm()->getAdditionalParams()->getElementId() ?>"
        <?php else: ?>
            data-form="<?= $element->getForm()->getTag() ?>"
        <?php endif; ?>
    ></div>
    <?= csrf_field() ?>

