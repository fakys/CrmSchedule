<?php
/**
 * @var Input $element
 * @var ViewErrorBag $errors
 * @var \App\Services\Views\Infrastructure\Services\ViewManager $viewManager
 */

use App\Services\Forms\Infrastructure\Services\FormElement\Input;
use App\Services\Validation\Infrastructure\Services\ValidationJsBuilder;
use Illuminate\Support\ViewErrorBag;

?>
<div>
    <input
        type="number"
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
            id="<?= $element->getAdditionalParams()->getElementId() ?>"
        <?php else:?>
            id="<?= $element->getName() ?>"
        <?php endif; ?>
        <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
            class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
        <?php endif; ?>
        name="<?=$element->getName()?>"
        value="<?=$element->getValue()?>"
        placeholder="<?=$element->getAdditionalParams()->getPlaceholder()?>"
        hidden="hidden"
    >


    <div id="<?=$element->getName()?>_error" class="invalid-feedback">
        <?php if ($errors->get($element->getName())): ?>
            <?=$errors->get($element->getName())[0]?>
        <?php endif; ?>
    </div>
    <?php foreach ($element->getElementsByGroup(ValidationJsBuilder::ELEMENT_GROUP_NAME) as $rule):?>
        <?=$viewManager->renderElement($rule)?>
    <?php endforeach;?>
</div>
