<?php
namespace App\Src\modules\operations;

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

    public function getOperation($name, $arguments)
    {
        foreach ($this->operations as $operation){
            if(method_exists($operation, $name)){
                return (new $operation())->$name($arguments);
            }
        }
        return null;
    }
    public function __call($name, $arguments){
        $this->getOperation($name, $arguments);
    }
}
