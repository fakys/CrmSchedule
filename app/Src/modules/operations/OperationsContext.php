<?php

namespace App\Src\modules\operations;

use Mockery\Exception;

class OperationsContext
{
    public array $operations;

    public function __construct(array $data_operation)
    {
        $this->operations = $data_operation;
    }

    public function get(): array
    {
        return $this->operations;
    }

    protected function getOperation($name, $arguments = [])
    {
        foreach ($this->operations as $operation) {
            if (method_exists($operation, $name)) {
                return call_user_func_array([new $operation (), $name], $arguments);
            }
        }
        throw new Exception("Операция не найдена", 500);
    }

    public function __call($name, $arguments)
    {
        return $this->getOperation($name, $arguments);
    }
}
