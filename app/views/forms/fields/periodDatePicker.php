<?php

/**
 * @var PeriodDatePicker $element
 */

use App\Services\Forms\Infrastructure\Services\FormElement\PeriodDatePicker;

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
    <div class="input-group">
        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
        </div>
        <input type="text" name="<?=$element->getName()?>"
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementClasses()): ?>
                class="<?= implode(' ', $element->getAdditionalParams()->getElementClasses()) ?>"
            <?php else: ?>
                class="form-control float-right"
            <?php endif; ?>
            <?php if ($element->getAdditionalParams() && $element->getAdditionalParams()->getElementId()): ?>
                id="<?= $element->getAdditionalParams()->getElementId() ?>"
            <?php else:?>
                id="<?= $element->getName() ?>"
            <?php endif; ?>
               value="<?=$element->getValue()?>">
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#<?= $element->getName() ?>').daterangepicker({
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Сохранить",
                "cancelLabel": "Назад",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1,
            }});
    })
</script>
