<?php

namespace App\Modules\Crm\lessons\models;

use App\Assets\JsTableBundle;
use App\Services\Table\Infrastructure\Services\AbstractTable;

class AllSubjectTable extends AbstractTable
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
            'name' => 'Название', 'full_name' => 'Полное название',
            'description' => 'Описание', 'created_at' => 'Дата добавления'
        ];
    }
}
