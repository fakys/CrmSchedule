<?php

namespace App\Services\AssetsBundle\Domain\Exceptions;

class UndefinedFileException extends \Exception
{
    public function __construct($file)
    {
        parent::__construct("Файл $file не найден");
    }
}
