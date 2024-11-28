<?php
namespace App\Src\modules\models;

interface InterfaceModel{
    public function fields(): array;
    public function rules(): array;

    public function boolean():array;
}
