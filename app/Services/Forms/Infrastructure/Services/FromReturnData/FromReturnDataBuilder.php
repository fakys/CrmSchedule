<?php

namespace App\Services\Forms\Infrastructure\Services\FromReturnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataBuilderInterface;
use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;
use ReflectionClass;

class FromReturnDataBuilder implements FromReturnDataBuilderInterface
{

    public function loadReturnData(FromReturnDataInterface $returnData, array $data): FromReturnDataInterface
    {
       $reflection = new ReflectionClass($returnData);

       foreach ($reflection->getProperties() as $property) {
           foreach ($property->getAttributes() as $attribute) {
               if (ReturnDataFieldAttribute::class === $attribute->getName()) {
                   foreach ($data as $field => $value) {
                       if ($attribute->getArguments()[array_key_first($attribute->getArguments())] == $field) {
                           $property->setValue($returnData, $value);
                       }
                   }
               }
           }
       }

        return $returnData;
    }
}
