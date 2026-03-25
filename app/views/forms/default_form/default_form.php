<?php
/**
 * @var FormInterface $element
 * @var ViewManagerInterface $viewManager
 */

use App\Services\Forms\Domain\Services\FormInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;

?>

<?= $viewManager->renderElement($element->startForm())?>
    <?php foreach ($element->getElements() as $elem): ?>
        <?= $viewManager->renderElement($elem) ?>
    <?php endforeach; ?>
<?= $viewManager->renderElement($element->endForm())?>
