<?php

namespace app\filters;

use app\helpers\App;
use yii\web\ForbiddenHttpException;

class UserFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (! App::isControllerAction('site/error')) {
            if (App::isLogin() && App::identity('is_blocked')) {
                throw new ForbiddenHttpException('User is Blocked !');
            }
        }

        return true;
    }
}