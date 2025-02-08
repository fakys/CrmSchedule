<?php

$arr =  [
    'base_namespace'=>"App\\Modules",
    'base_path'=>base_path()."/app/Modules",
    'web_path'=>"routes/web.php",
    'public_modules'=>[
        'auth'
    ],
    'modules'=>[
        'Crm'=>[
            'backend_module',
            'interface',
            'system_settings',
            'modules_settings',
            'users_interface',
            'auth',
            'lessons',
            'schedule',
            'student_groups'
        ],
        'Api'=>[]
    ],
];
