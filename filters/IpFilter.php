<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\search\IpSearch;
use app\models\Ip;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class IpFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (($ip = App::ip()) != null) {
            $modelIP = Ip::findOne($modelIP);
            if (!$modelIP) {
                $model = new Ip([
                    'record_status' => 1,
                    'name' => $ip,
                    'type' => 1
                ]);

                $model->save();
            }
        }

           
        if (! App::isControllerAction('site/error')) {
            if (in_array(App::ip(), IpSearch::blocked())) {
                throw new ForbiddenHttpException('IP is Blocked !');
                return false;
            }
        }
        
        return true;
    }
}