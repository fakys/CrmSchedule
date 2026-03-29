<?php
namespace App\Modules\Crm\lessons\models;

use App\Assets\JsTableBundle;
use App\Services\Table\Infrastructure\Services\AbstractTable;

class LessonsTable extends AbstractTable
{

    public function getAssets(): array
    {
        return [
            JsTableBundle::class
        ];
    }

    public function getColumns(): array
    {
        return ['fio'=>'Фио преподавателя', 'subject_full_name'=>'Название предмета'];
    }
}
