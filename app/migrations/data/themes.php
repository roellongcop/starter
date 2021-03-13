<?php
$keenDemo1Bundles = [
    'yii\web\JqueryAsset' => [
        'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
        'sourcePath' => '@app/themes/keen/sub/demo1/main/assets/assets/plugins/global/',
        'js' => ['plugins.bundle.js']
    ],  
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => '@app/themes/keen/sub/demo1/main/assets/assets/plugins/global/',
        'css' => ['plugins.bundle.css']
    ],  
];

$keenDemo2Bundles = [
    'yii\web\JqueryAsset' => [
        'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
        'sourcePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets/plugins/global/',
        'js' => ['plugins.bundle.js']
    ],  
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets/plugins/global/',
        'css' => ['plugins.bundle.css']
    ],  
];


$keenDemo3Bundles = [
    'yii\web\JqueryAsset' => [
        'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
        'sourcePath' => '@app/themes/keen/sub/demo3/fixed/assets/assets/plugins/global/',
        'js' => ['plugins.bundle.js']
    ],  
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => '@app/themes/keen/sub/demo3/fixed/assets/assets/plugins/global/',
        'css' => ['plugins.bundle.css']
    ],  
];



return [
    1 => [
        'id' => 1,
        'description' => 'keen/sub/demo1/main',
        'name' => 'Demo1 Main',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => '@app/themes/keen/sub/demo1/main/views',
            '@app/widgets' => '@app/themes/keen/sub/demo1/main/widgets',
        ],
        'bundles' => $keenDemo1Bundles
    ],
    2 => [
        'id' => 2,
        'description' => 'keen/sub/demo1/fluid',
        'name' => 'Demo1 Main Fluid',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/fluid/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/fluid/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ]
        ],
        'bundles' => $keenDemo1Bundles
    ],
    3 => [
        'id' => 3,
        'description' => 'keen/sub/demo1/light',
        'name' => 'Light',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/light/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/light/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    4 => [
        'id' => 4,
        'description' => 'keen/sub/demo1/lightFluid',
        'name' => 'Light Fluid',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/lightFluid/views',
                '@app/themes/keen/sub/demo1/light/views',
                '@app/themes/keen/sub/demo1/fluid/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/lightFluid/widgets',
                '@app/themes/keen/sub/demo1/light/widgets',
                '@app/themes/keen/sub/demo1/fluid/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    5 => [
        'id' => 5,
        'description' => 'keen/sub/demo1/dark',
        'name' => 'Dark',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/dark/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/dark/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    6 => [
        'id' => 6,
        'description' => 'keen/sub/demo1/darkFluid',
        'name' => 'Dark Fluid',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/darkFluid/views',
                '@app/themes/keen/sub/demo1/dark/views',
                '@app/themes/keen/sub/demo1/fluid/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/darkFluid/widgets',
                '@app/themes/keen/sub/demo1/dark/widgets',
                '@app/themes/keen/sub/demo1/fluid/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    7 => [
        'id' => 7,
        'description' => 'keen/sub/demo1/noAsideLight',
        'name' => 'No-aside Light',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/noAsideLight/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    8 => [
        'id' => 8,
        'description' => 'keen/sub/demo1/noAsideLightFluid',
        'name' => 'No-aside Light Fluid',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/noAsideLightFluid/views',
                '@app/themes/keen/sub/demo1/noAsideLight/views',
                '@app/themes/keen/sub/demo1/fluid/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/noAsideLightFluid/widgets',
                '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                '@app/themes/keen/sub/demo1/fluid/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    9 => [
        'id' => 9,
        'description' => 'keen/sub/demo1/noAsideDark',
        'name' => 'No-aside Dark',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/noAsideDark/views',
                '@app/themes/keen/sub/demo1/noAsideLight/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/noAsideDark/widgets',
                '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    10 => [
        'id' => 10,
        'description' => 'keen/sub/demo1/noAsideDarkFluid',
        'name' => 'No-aside Dark Fluid',
        'basePath' => '@app/themes/keen/sub/demo1/main/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo1/main',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo1/noAsideDarkFluid/views',
                '@app/themes/keen/sub/demo1/noAsideLight/views',
                '@app/themes/keen/sub/demo1/fluid/views',
                '@app/themes/keen/sub/demo1/main/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo1/noAsideDarkFluid/widgets',
                '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                '@app/themes/keen/sub/demo1/fluid/widgets',
                '@app/themes/keen/sub/demo1/main/widgets',
            ],
        ],
        'bundles' => $keenDemo1Bundles
    ],
    11 => [
        'id' => 11,
        'description' => 'starter',
        'name' => 'Starter',
        'basePath' => '@app/assets/',
        'baseUrl' => '@web/themes/starter',
        'pathMap' => [
            '@app/views' => ['@app/views'],
            '@app/widgets' => ['@app/widgets'],
        ],
    ],
    12 => [
        'id' => 12,
        'description' => 'keen/sub/demo2/fixed',
        'name' => 'Demo2 Fixed',
        'basePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo2/fixed',
        'pathMap' => [
            '@app/views' => '@app/themes/keen/sub/demo2/fixed/views',
            '@app/widgets' => '@app/themes/keen/sub/demo2/fixed/widgets',
        ],
        'bundles' => $keenDemo2Bundles
    ],
    13 => [
        'id' => 13,
        'description' => 'keen/sub/demo2/fluid',
        'name' => 'Demo2 Fluid',
        'basePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets',
        'baseUrl' => '@web/themes/keen/sub/demo2/fixed',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keen/sub/demo2/fluid/views',
                '@app/themes/keen/sub/demo2/fixed/views',
            ],
            '@app/widgets' => [
                '@app/themes/keen/sub/demo2/fluid/widgets',
                '@app/themes/keen/sub/demo2/fixed/widgets',
            ],
        ],
        'bundles' => $keenDemo2Bundles
    ],
    14 => [
        'id' => 14,
        'description' => 'keenDemo3/fixed',
        'name' => 'Demo3 Fixed',
        'basePath' => '@app/themes/keenDemo3/fixed/assets/assets',
        'baseUrl' => '@web/themes/keenDemo3/fixed',
        'pathMap' => [
            '@app/views' => '@app/themes/keenDemo3/fixed/views',
            '@app/widgets' => '@app/themes/keenDemo3/fixed/widgets',
        ],
        'bundles' => $keenDemo3Bundles
    ],
    15 => [
        'id' => 15,
        'description' => 'keenDemo3/fluid',
        'name' => 'Demo3 Fluid',
        'basePath' => '@app/themes/keenDemo3/fixed/assets/assets',
        'baseUrl' => '@web/themes/keenDemo3/fixed',
        'pathMap' => [
            '@app/views' => [
                '@app/themes/keenDemo3/fluid/views',
                '@app/themes/keenDemo3/fixed/views',
            ],
            '@app/widgets' => [
                '@app/themes/keenDemo3/fluid/widgets',
                '@app/themes/keenDemo3/fixed/widgets',
            ],
        ],
        'bundles' => $keenDemo3Bundles
    ],
];