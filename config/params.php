<?php


return [

    'general_settings' => [
        
        'whitelist_ip_only' => [
            'name' => 'whitelist_ip_only',
            'default' => 0,
        ],

        'theme' => [
            'name' => 'theme',
            'default' => 1,
        ],
        'timezone' => [
            'name' => 'timezone',
            'default' => 'Asia/Manila',
        ],
        'pagination' => [
            'name' => 'pagination',
            'default' => 20,
        ],
      
        'admin_email' => [
            'name' => 'admin_email',
            'default' => 'admin@example.com'
        ],
        'sender_email' => [
            'name' => 'sender_email',
            'default' => 'noreply@example.com'
        ],
        'sender_name' => [
            'name' => 'sender_name',
            'default' => 'Example.com mailer'
        ],
        'primary_logo' => [
            'name' => 'primary_logo',
            'default' => 'https://via.placeholder.com/200'
        ],
        'secondary_logo' => [
            'name' => 'secondary_logo',
            'default' => 'https://via.placeholder.com/200'
        ],
        'image_holder' => [
            'name' => 'image_holder',
            'default' => 'https://via.placeholder.com/200'
        ],
        'favicon' => [
            'name' => 'favicon',
            'default' => 'https://via.placeholder.com/200'
        ],
        'auto_logout_timer' => [
            'name' => 'auto_logout_timer',
            'default' => 1440
        ],
    ],
  

    

    'file_extensions' => [
        'image' => ['jpeg', 'jpg', 'gif', 'bmp', 'tiff','png', 'ico',],
        'file' => ['doc', 'docx', 'pdf', 'xls', 'xlxs', 'csv', 'sql'],
    ],
    
    'export_actions' => [
        'print', 
        'export-pdf', 
        'export-csv', 
        'export-xls', 
        'export-xlsx'
    ],

    'visit_logs_action' => [
        0 => [
            'id' => 0,
            'label' => 'Login',
            'class' => 'success'
        ],
        1 => [
            'id' => 1,
            'label' => 'Logout',
            'class' => 'danger'
        ],
    ],

    

    'user_status' => [
        0 => [
            'id' => 0,
            'label' => 'Archived',
            'class' => 'danger'
        ],
        9 => [
            'id' => 9,
            'label' => 'Not Verified',
            'class' => 'warning'
        ],
        10 => [
            'id' => 10,
            'label' => 'Active',
            'class' => 'success'
        ],
    ],
    'record_status' => [
        1 => [
            'id' => 1,
            'label' => 'Active',
            'class' => 'success'
        ],
        0 => [
            'id' => 0,
            'label' => 'In-active',
            'class' => 'danger'
        ],
        
    ],


    'is_blocked' => [
        0 => [
            'id' => 0,
            'label' => 'Allowed',
            'class' => 'success'
        ],
        1 => [
            'id' => 1,
            'label' => 'Blocked',
            'class' => 'danger'
        ],
    ],

    'ip_type' => [
        0 => [
            'id' => 0,
            'label' => 'Black List',
            'class' => 'success'
        ],
        1 => [
            'id' => 1,
            'label' => 'White List',
            'class' => 'danger'
        ],
    ],

    'pagination' => [
        20 => 20,
        50 => 50,
        100 => 100,
        250 => 250,
        500 => 500,
        1000 => 1000,
    ], 

    'keen_themes' => [
        'demo1-main',
        'demo1-main-fluid',
        'light',
        'light-fluid',
        'dark',
        'dark-fluid',
        'no-aside-light',
        'no-aside-light-fluid',
        'no-aside-dark',
        'no-aside-dark-fluid',
        'demo2-fixed',
        'demo2-fluid',
        'demo3-fixed',
        'demo3-fluid',
    ],

    'setting_modules' => [
        'system' => ['label' => 'System', 'icon' => '<i class="fas fa-cog"></i>'],
        'email' => ['label' => 'Email', 'icon' => '<i class="far fa-envelope"></i>'],
        'image' => ['label' => 'Image', 'icon' => '<i class="far fa-file-image"></i>'],
    ]
];
