<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\search\IpSearch;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class IpFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

           
        if (! App::controllerAction('site/error')) {
            if (in_array(App::ip(), IpSearch::blocked())) {
                throw new ForbiddenHttpException('IP is Blocked !');
                return false;
            }
        }
        
        return true;
    }
}