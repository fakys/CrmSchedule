<?php

namespace App\Modules\RestApi\schedule_api\models;

class ReturnBool
{
    public $return_data;
    public function __construct($data)
    {
        $this->return_data = (bool)$data;
    }

    public static function return($data)
    {
        return (new self($data))->getData();
    }

    public function getData():bool
    {
        return $this->return_data;
    }
}
