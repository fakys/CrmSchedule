<?php
/**
 * @var FormInterface $element
 * @var ViewManagerInterface $viewManager
 */

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;

?>

<form method="<?= $element->getAdditionalParams()->getMethod() ?>"
    <?php if ($element->getAdditionalParams()->getElementId()): ?>
        id="<?= $element->getAdditionalParams()->getElementId() ?>"
    <?php else: ?>
        id="<?= $element->getTag() ?>"
    <?php endif; ?>
    <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
        class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
    <?php endif; ?>
    <?php if($element->getAdditionalParams()->getUrl()): ?> action="<?=$element->getAdditionalParams()->getUrl()?>" <?php endif; ?>
>
    <div class="validate-js-name"
        <?php if ($element->getAdditionalParams()->getElementId()): ?>
            data-form="<?= $element->getAdditionalParams()->getElementId() ?>"
        <?php else: ?>
            data-form="<?= $element->getTag() ?>"
        <?php endif; ?>
    ></div>
    <?= csrf_field() ?>
    <?php foreach ($element->getElements() as $elem): ?>
        <?= $viewManager->renderElement($elem) ?>
    <?php endforeach; ?>
</form>

