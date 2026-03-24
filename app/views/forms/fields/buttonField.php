<?php


use App\Core\Forms\Infrastructure\Services\FormElement\Button;

/**
 * @var Button $element
 */

?>
<div class="form-group">
    <?php if ($element->getLabel()): ?>
        <label
            for="<?= $element->getName() ?>"
            <?php if ($element->getLabel()->getLabelId()): ?>
                id="<?= $element->getLabel()->getLabelId() ?>"
            <?php endif; ?>
            <?php if ($element->getLabel()->getLabelClass()): ?>
                class="<?= implode(' ', $element->getLabel()->getLabelClass()) ?>"
            <?php endif; ?>
        >
            <?= $element->getLabel()->getLabel() ?>
        </label>
    <?php endif ?>
    <button
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
            id="<?= $element->getAdditionalParams()->getElementId() ?>"
        <?php else:?>
            id="<?= $element->getName() ?>"
        <?php endif; ?>
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
            class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
        <?php else: ?>
            class="btn btn-primary"
        <?php endif; ?>
    ><?=$element->getText()?></button>
</div>
