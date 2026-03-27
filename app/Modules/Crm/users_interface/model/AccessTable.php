<?php
namespace App\Modules\Crm\users_interface\model;

use App\Assets\JsTableBundle;
use App\Services\Table\Infrastructure\Services\AbstractTable;

class AccessTable extends AbstractTable
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
            'id'=>'#', 'name'=>'Название', 'url'=>'Url',
            'description'=>'Описание'
        ];
    }
}
