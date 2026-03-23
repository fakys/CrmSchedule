<?php

namespace App\Services\Forms\Domain\Services\FormLoader;



use App\Services\Forms\Domain\Services\FormInterface;

interface FormLoaderInterface
{
    public function loadForm(FormInterface $form, $data);

}
