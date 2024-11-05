<?php

return [
    'base_namespace'=>"App\\Modules",
    'base_path'=>base_path()."/app/Modules",
    'web_path'=>"routes/web.php",
    'modules'=>[
        'Crm'=>[
            'backend_module',
            'interface',
            'system_settings'
        ],
        'Api'=>[]
    ],
];
