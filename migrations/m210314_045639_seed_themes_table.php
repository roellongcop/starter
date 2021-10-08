<?php

use yii\helpers\Inflector;
use yii\db\Expression;

/**
 * Class m210314_045639_seed_themes_table
 */
class m210314_045639_seed_themes_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%themes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->themes() as $i => $theme) {
            $data = [
                'description' => $theme['description'],
                'name' => $theme['name'],
                'base_path' => $theme['basePath'],
                'base_url' => $theme['baseUrl'],
                'path_map' => json_encode($theme['pathMap']),
                'bundles' => json_encode($theme['bundles'] ?? []),
                'slug' => Inflector::slug($theme['name']),
                'record_status' => Theme::RECORD_ACTIVE,
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' => new Expression('UTC_TIMESTAMP'),
                'photos' => json_encode([
                    'default-6ccb4a66-0ca3-46c7-88dd-default',
                    'default-6ccb4a66-0ca3-46c7-88dd-default'
                ])
            ];
            $this->insert($this->tableName(), $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName());
    }

    public function themes()
    {
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
                    '@app/views' => [
                        '@app/themes/keen/sub/demo1/main/views',
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
                    ],
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/fluid/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/light/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/lightFluid/widgets',
                        '@app/themes/keen/sub/demo1/light/widgets',
                        '@app/themes/keen/sub/demo1/fluid/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/dark/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/darkFluid/widgets',
                        '@app/themes/keen/sub/demo1/dark/widgets',
                        '@app/themes/keen/sub/demo1/fluid/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/noAsideLightFluid/widgets',
                        '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                        '@app/themes/keen/sub/demo1/fluid/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/noAsideDark/widgets',
                        '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
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
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo1/noAsideDarkFluid/widgets',
                        '@app/themes/keen/sub/demo1/noAsideLight/widgets',
                        '@app/themes/keen/sub/demo1/fluid/widgets',
                        '@app/themes/keen/sub/demo1/main/widgets',
                        '@app/themes/keen/widgets',
                    ],
                ],
                'bundles' => $keenDemo1Bundles
            ],
            11 => [
                'id' => 11,
                'description' => 'keen/sub/demo2/fixed',
                'name' => 'Demo2 Fixed',
                'basePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets',
                'baseUrl' => '@web/themes/keen/sub/demo2/fixed',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/keen/sub/demo2/fixed/views',
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo2/fixed/widgets',
                        '@app/themes/keen/widgets',
                    ],
                ],
                'bundles' => $keenDemo2Bundles
            ],
            12 => [
                'id' => 12,
                'description' => 'keen/sub/demo2/fluid',
                'name' => 'Demo2 Fluid',
                'basePath' => '@app/themes/keen/sub/demo2/fixed/assets/assets',
                'baseUrl' => '@web/themes/keen/sub/demo2/fixed',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/keen/sub/demo2/fluid/views',
                        '@app/themes/keen/sub/demo2/fixed/views',
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo2/fluid/widgets',
                        '@app/themes/keen/sub/demo2/fixed/widgets',
                        '@app/themes/keen/widgets',
                    ],
                ],
                'bundles' => $keenDemo2Bundles
            ],
            13 => [
                'id' => 13,
                'description' => 'keen/sub/demo3/fixed',
                'name' => 'Demo3 Fixed',
                'basePath' => '@app/themes/keen/sub/demo3/fixed/assets/assets',
                'baseUrl' => '@web/themes/keen/sub/demo3/fixed',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/keen/sub/demo3/fixed/views',
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo3/fixed/widgets',
                        '@app/themes/keen/widgets',
                    ],
                ],
                'bundles' => $keenDemo3Bundles
            ],
            14 => [
                'id' => 14,
                'description' => 'keen/sub/demo3/fluid',
                'name' => 'Demo3 Fluid',
                'basePath' => '@app/themes/keen/sub/demo3/fixed/assets/assets',
                'baseUrl' => '@web/themes/keen/sub/demo3/fixed',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/keen/sub/demo3/fluid/views',
                        '@app/themes/keen/sub/demo3/fixed/views',
                        '@app/themes/keen/views',
                    ],
                    '@app/widgets' => [
                        '@app/themes/keen/sub/demo3/fluid/widgets',
                        '@app/themes/keen/sub/demo3/fixed/widgets',
                        '@app/themes/keen/widgets',
                    ],
                ],
                'bundles' => $keenDemo3Bundles
            ],
        ];
    }
}