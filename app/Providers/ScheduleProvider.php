<?php
namespace App\Providers;


use App\Src\providers\AbstractScheduleProvider;
use App\Src\providers\InterfaceProvider;

class ScheduleProvider extends AbstractScheduleProvider implements InterfaceProvider{

    public function register()
    {
        $this->module->RunConfig();
    }
}
