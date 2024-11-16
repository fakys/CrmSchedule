<?php
namespace App\Src\providers;

abstract class AbstractScheduleProvider{
    protected $request;
    protected $module;
    public function __construct($request, $module)
    {
        $this->request = $request;
        $this->module = $module;
    }
}
