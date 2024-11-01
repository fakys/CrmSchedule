<?php
namespace App\Modules\Crm\backend_module\componnets\repositories;

use App\Src\modules\repository\AbstractRepositories;

class Test2Repository extends AbstractRepositories{
    public function test2($data)
    {
        dd($data);
    }
}
