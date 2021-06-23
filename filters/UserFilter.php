<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class UserFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (! App::isControllerAction('site/error')) {
            if (App::isLogin() && App::identity('is_blocked')) {
                throw new ForbiddenHttpException('User is Blocked !');
                return false;
            }
        }

        return true;
    }
}