<?php

namespace app\components;

class UrlManagerComponent extends \yii\web\UrlManager
{
    public $enablePrettyUrl = true;
    public $showScriptName = false;
    public $rules = [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'api/v1/user',
            'pluralize' => false
        ],

        'my-files' => 'file/my-files',
        'my-setting' => 'setting/my-setting',
        'my-role' => 'role/my-role',
        'my-account' => 'user/my-account',
        'my-password' => 'user/my-password',

        '<action:index|login|reset-password|contact>' => 'site/<action>',

        'setting/general/<tab>' => 'setting/general',
        'setting/general' => 'setting/general',

        'setting/<action>/<name>' => 'setting/<action>',


        '<controller>' => '<controller>/index',
        '<controller:(notification)>/<action>/<token>' => '<controller>/<action>',
        '<controller:(ip|user|theme|backup|role)>/<action>/<slug>' => '<controller>/<action>',

        '<controller>/<id:\d+>' => '<controller>/view',
        '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
        '<controller>/<action>' => '<controller>/<action>',
    ];
}