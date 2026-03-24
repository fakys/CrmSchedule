<?php
/**
 * @var AbstractRule $element
 */

use App\Core\Validation\Infrastructure\Services\ValidationJsRules\Abstracts\AbstractRule;

?>

<div class="validate-js-rule" data-name="<?= $element->ruleName() ?>" data-field="<?= $element->getFieldName() ?>"
     data-message="<?= $element->getMessage() ?>"
    <?php foreach ($element->getAdditionalParams()->getAttributes() as $attribute=>$value):?>
    data-<?=$attribute?>="<?=$value?>"
    <?php endforeach; ?>
    data-type_field="<?=$element->getType()?>"
></div>
