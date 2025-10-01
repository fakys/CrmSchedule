<?php
namespace App\Modules\Crm\backend_module\operations;

use App\Src\modules\operations\AbstractOperation;

class TestOperation extends AbstractOperation
{

    public function getName(): string
    {
        return 'test_operation';
    }

    public function test()
    {

        return $this->getNext()->test();
    }
}
