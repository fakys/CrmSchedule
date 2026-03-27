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
    <input
        type="checkbox"
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
            id="<?= $element->getAdditionalParams()->getElementId() ?>"
        <?php else: ?>
            id="<?= $element->getName() ?>"
        <?php endif; ?>
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
            class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?> <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
        <?php else: ?>
            class="form-check-input <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
        <?php endif; ?>
           name="<?= $element->getName() ?>"
           <?php if($element->getValue() || old($element->getName())): ?> checked <?php endif; ?>
    >
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
    <?php if ($errors->get($element->getName())): ?>
        <div id="<?= $element->getName() ?>_error" class="invalid-feedback">
            <?= $errors->get($element->getName())[0] ?>
        </div>
    <?php endif; ?>

    <?php foreach ($element->getElementsByGroup(ValidationJsBuilder::ELEMENT_GROUP_NAME) as $rule): ?>
        <?= $viewManager->renderElement($rule) ?>
    <?php endforeach; ?>
</div>
