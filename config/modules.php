<?php

return [
    'base_namespace'=>"App\\Modules",
    'base_path'=>__DIR__."/../app/Modules",
    'web_path'=>"routes/web.php",
    'public_modules'=>[
        'auth'
    ],
    'modules'=>[
        'Crm'=>[
            'backend_module',
            'holidays',
            'interface',
            'system_settings',
            'modules_settings',
            'users_interface',
            'auth',
            'lessons',
            'schedule',
            'student_groups',
            'schedule_plan'
        ],
        'Api'=>[]
    ],
];
