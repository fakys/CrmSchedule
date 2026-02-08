<?php

return [
    //Точка старта
    App\Providers\AppServiceProvider::class,
    //Модули
    \App\Modules\Crm\backend_module\providers\BackendModuleProvider::class,
    \App\Modules\Crm\system_settings\providers\SystemSettingsProvider::class,
    \App\Modules\Crm\student_groups\providers\StudentGroupsProvider::class,
    \App\Modules\Crm\schedule\providers\ScheduleModuleProvider::class,
    \App\Modules\Crm\schedule_plan\providers\SchedulePlanProvider::class,
    \App\Modules\Crm\users_interface\providers\UsersInterfaceeProvider::class,
    \App\Modules\Crm\auth\providers\AuthModuleProvider::class,
    \App\Modules\Crm\interface\providers\InterfaceProvider::class,
    \App\Modules\Crm\lessons\providers\LessonsProvider::class,
    \App\Modules\Crm\modules_settings\providers\ModulesSettingsProvider::class,
    \App\Modules\Crm\reports\providers\ReportProvider::class,
    \App\Modules\Crm\holidays\providers\HolidaysProvider::class,
    \App\Modules\RestApi\schedule_api\providers\RestApiProvider::class,
];
