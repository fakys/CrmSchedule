<?php
namespace App\Src\modules\models;

interface InterfaceModel{
    public static function getSettingName():string;
    public function fields(): array;
    public function rules(): array;

    public function boolean():array;
}
