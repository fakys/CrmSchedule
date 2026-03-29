<?php
namespace App\Modules\Crm\student_groups\models;

use App\Assets\JsTableBundle;
use App\Services\Table\Infrastructure\Services\AbstractTable;

class StudentGroupTable extends AbstractTable
{

    public function getAssets(): array
    {
        return [
            JsTableBundle::class
        ];
    }

    public function getColumns(): array
    {
        return [
            'number'=>'Номер группы', 'name'=>'Название группы', 'specialties'=>'Специальность', 'specialty_description'=>'Описание специальности'
        ];
    }
}
