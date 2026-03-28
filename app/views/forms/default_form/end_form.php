<?php
/**
 * @var \App\Services\Forms\Infrastructure\Services\FormElement\Form\FormEndElement $element
 * @var ViewManagerInterface $viewManager
 */

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;

?>

</form>

<?php if ($element->getForm()->isAjax()): ?>
<script>
    $(document).ready(function() {
        $(<?=$element->getForm()->getTag()?>).off('submit');
        $(<?=$element->getForm()->getTag()?>).on('submit', function(event) {
            event.preventDefault();
            console.log(123123123)
            var $form = $(this);
            var url = $form.attr('action');
            var formData = $form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,

                success: function(response) {
                    success_alert('Данные успешно сохранены !')
                },

                error: function(err) {
                    error_alert(err.responseJSON.message)
                }
            });
        });
    });
</script>
<?php endif; ?>
