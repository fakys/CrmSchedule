<?php
/**
 * @var \App\Core\Forms\Infrastructure\Services\FormElement\DoubleRange\DoubleRange $element
 * @var ViewErrorBag $errors
 * @var \App\Core\Views\Infrastructure\Services\ViewManager $viewManager
 * @var \App\Services\AssetsBundle\Infrastructure\Services\AssetBundleManager $assetsBundleManager
 */

use Illuminate\Support\ViewErrorBag;

?>
<div class="form-group">
    <?php if ($element->getLabel()): ?>
        <label
            for="<?= $element->getTag() ?>"
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
    <div class="pt-3">
        <div id="price-range"></div>
        <?=$viewManager->renderElement($element->getElements()[$element->getAdditionalParams()->getMinName()])?>
        <?=$viewManager->renderElement($element->getElements()[$element->getAdditionalParams()->getMaxName()])?>
    </div>
    <?=$assetsBundleManager->registerFile('resources/js/plugins/nouislider.min.js')?>
    <script>
        const slider = document.getElementById('price-range');
        const inputMin = document.getElementById('<?=$element->getAdditionalParams()->getMinName()?>');
        const inputMax = document.getElementById('<?=$element->getAdditionalParams()->getMaxName()?>');


        noUiSlider.create(slider, {
            //todo VALUE
            start: [18, 60],
            connect: true,
            range: {
                'min': <?=$element->getMin()?>,
                'max': <?=$element->getMax()?>
            },
            step: <?=$element->getStep()?>,
            tooltips: [true, true],
            format: {
                to: function (value) {
                    return Math.round(value);
                },
                from: function (value) {
                    return Number(value);
                }
            }
        });

        slider.noUiSlider.on('update', function (values, handle) {
            const value = values[handle];

            if (handle === 0) {
                inputMin.value = Math.round(value);
            } else {
                inputMax.value = Math.round(value);
            }
        });


        function setInputValues() {
            slider.noUiSlider.set([inputMin.value, inputMax.value]);
        }

        inputMin.addEventListener('change', setInputValues);
        inputMax.addEventListener('change', setInputValues);


        inputMin.addEventListener('input', function() {
            let val = parseInt(this.value);
            if(val < 0) val = 0;
            if(val > parseInt(inputMax.value)) val = parseInt(inputMax.value);

            slider.noUiSlider.set([val, null]);
        });

        inputMax.addEventListener('input', function() {
            let val = parseInt(this.value);
            if(val >  <?=$element->getMax()?>) val = <?=$element->getMax()?>;
            if(val < parseInt(inputMin.value)) val = parseInt(inputMin.value);

            slider.noUiSlider.set([null, val]);
        });
    </script>
</div>
