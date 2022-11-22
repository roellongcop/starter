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

        $ip = App::ip();


        if (! App::isControllerAction('site/error')) {
            if (in_array($ip, IpSearch::blackList())) {
                throw new ForbiddenHttpException('IP is Blocked !');
                return false;
            }

            if (App::setting('system')->whitelist_ip_only) { 
                if (! in_array($ip, IpSearch::whiteList())) {
                    throw new ForbiddenHttpException('IP not WhiteListed.');
                    return false;
                }
            }
        }

        $modelIP = Ip::findOne($ip);
        if (!$modelIP) {
            $model = new Ip([
                'record_status' => 1,
                'name' => $ip,
                'type' => Ip::TYPE_WHITELIST,
                'description' => 'IP Session: ' . App::session('id')
            ]);
            $model->save();
        }
        
        return true;
    }
}