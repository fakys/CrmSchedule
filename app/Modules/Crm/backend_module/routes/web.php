<?php

use App\Modules\Crm\backend_module\InfoModule;
use App\Src\access\AccessRoute;
use Illuminate\Support\Facades\Route;

AccessRoute::access("navbar_arm_supervisor");
AccessRoute::access("navbar_arm_teacher");
