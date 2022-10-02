<?php

namespace app\modules\api\v1\components;

class ResponseComponent extends \yii\web\Response
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['ApiBehavior'] = '\app\modules\api\v1\behaviors\ApiBehavior';

        return $behaviors;
    }
}