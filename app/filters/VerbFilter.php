<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\filters;

use Yii;
 
class VerbFilter extends \yii\filters\VerbFilter
{
    public $verbActions = [
        'index'  => ['get'],
        'view'   => ['get'],
        'create' => ['get', 'post'],
        'update' => ['get', 'put', 'post'],
        'delete' => ['post', 'delete'],
    ];

    public function init()
    {
        parent::init();
        $this->actions =  $this->verbActions;
    }
}
