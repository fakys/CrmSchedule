<?php

namespace App\Services\Forms\Domain\Services\FormReturnData;



interface FromReturnDataBuilderInterface
{
    public function loadReturnData(FromReturnDataInterface $returnData, array $data): FromReturnDataInterface;
}
