<?php
namespace App\Modules\Crm\backend_module\componnets\repositories;

use App\Src\modules\repository\AbstractRepositories;

class TestRepository extends AbstractRepositories{
    public function test()
    {
        dd("test");
    }
}
