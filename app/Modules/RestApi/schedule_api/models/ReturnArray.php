<?php

namespace App\Modules\RestApi\schedule_api\models;

class ReturnArray
{
    public $return_data;
    public function __construct($data)
    {
        $this->return_data = (array)$data;
    }

    public static function return($data)
    {
        return (new self($data))->getData();
    }

    public function getData()
    {
        return json_encode($this->return_data);
    }
}
