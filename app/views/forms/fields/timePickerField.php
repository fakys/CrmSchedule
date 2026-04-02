<?php
/**
 * @var FormElementInterface $element
 * @var ViewErrorBag $errors
 * @var \App\Services\Views\Infrastructure\Services\ViewManager $viewManager
 */

use App\Services\Forms\Domain\Services\FormElements\FormElementInterface;
use App\Services\Validation\Infrastructure\Services\ValidationJsBuilder;
use Illuminate\Support\ViewErrorBag;

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
    <div class="input-group clockpicker" data-placement="top" data-align="left" data-donetext="Выбрать">
        <input
            type="time"
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
                id="<?= $element->getAdditionalParams()->getElementId() ?>"
            <?php else: ?>
                id="<?= $element->getName() ?>"
            <?php endif; ?>
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
                class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?> <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
            <?php else: ?>
                class="form-control <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
            <?php endif; ?>
            name="<?= $element->getName() ?>"
            value="<?=$element->getValue() ? $element->getValue() : old($element->getName())?>"
        ><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
    </div>
    <?php if ($errors->get($element->getName())): ?>
        <div id="<?= $element->getName() ?>_error" class="invalid-feedback">
            <?= $errors->get($element->getName())[0] ?>
        </div>
    <?php endif; ?>

    <?php foreach ($element->getElementsByGroup(ValidationJsBuilder::ELEMENT_GROUP_NAME) as $rule): ?>
        <?= $viewManager->renderElement($rule) ?>
    <?php endforeach; ?>
</div>
