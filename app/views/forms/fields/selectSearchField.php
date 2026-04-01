<?php
/**
 * @var \App\Services\Forms\Infrastructure\Services\FormElement\SelectSearch $element
 * @var ViewErrorBag $errors
 * @var ViewManager $viewManager
 */

use App\Services\Validation\Infrastructure\Services\ValidationJsBuilder;
use App\Services\Views\Infrastructure\Services\ViewManager;
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
    <div>
        <select
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
                id="<?= $element->getAdditionalParams()->getElementId() ?>"
            <?php else:?>
                id="<?= $element->getName() ?>"
            <?php endif; ?>
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getMultiple()): ?>
                multiple
            <?php endif; ?>
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
                class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>
                <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
            <?php else: ?>
                class="form-control <?php if ($errors->get($element->getName())): ?> is-invalid <?php endif; ?>"
            <?php endif; ?>
            name="<?=$element->getName()?><?php if ($element->getAdditionalParams()->getMultiple()):?>[]<?php endif; ?>"
            style="width: 100%;"
        >
            <?php foreach ($element->getOptions() as $value => $name): ?>
                <?php if(
                    (is_array($element->getValue()) && in_array($value, $element->getValue()) || $element->getValue() == $value) ||
                    (is_array(old($element->getName())) && in_array($value, old($element->getName())) || old($element->getName()) == $value)
                ): ?>
                    <option value="<?=$value?>" selected><?=$name?></option>
                <?php else: ?>
                    <option value="<?=$value?>"><?=$name?></option>
                <?php endif;?>
            <?php endforeach;?>
        </select>

        <div id="<?=$element->getName()?>_error" class="invalid-feedback">
            <?php if ($errors->get($element->getName())): ?>
                <?=$errors->get($element->getName())[0]?>
            <?php endif; ?>
        </div>

        <?php foreach ($element->getElementsByGroup(ValidationJsBuilder::ELEMENT_GROUP_NAME) as $rule):?>
            <?=$viewManager->renderElement($rule)?>
        <?php endforeach;?>
        <script>
            $(document).ready(function (){
                $('#<?=$element->getAdditionalParams()->getElementId() ? $element->getAdditionalParams()->getElementId() : $element->getName()?>').select2()

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })
        </script>
    </div>
</div>

