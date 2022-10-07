<?php

namespace app\modules\api\v1;

use Yii;

/**
 * api module definition class
 */
class Version1Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here

        Yii::$app->user->enableSession = false;

        Yii::$app->setComponents([
            'user' => 'app\modules\api\v1\components\UserComponent',
            'request' => 'app\modules\api\v1\components\RequestComponent',
            'response' => 'app\modules\api\v1\components\ResponseComponent',
        ]);
    }
}