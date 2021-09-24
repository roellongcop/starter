<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Visitor;
use yii\web\Cookie;

class VisitorFilter extends \yii\base\ActionFilter
{
    public $duration = '1days';
    public $cookieId = 'app-visitor-id';

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has($this->cookieId)) {
            
            if (($model = Visitor::findByCookie($cookies->getValue($this->cookieId))) != NULL) {
                if ($model->isExpire()) {
                    $this->addCookie();
                }
            }
            else {
                $this->addCookie();
            }
        }
        else {
            $this->addCookie();
        }

        return true;
    }

    public function addCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $model = new Visitor([
            'expire' => strtotime(date('Y-m-d H:i:s') . " +{$this->duration}"),
        ]);


        if ($model->save()) {
            // add a new cookie to the response to be sent
            $cookies->add(new Cookie([
                'name' => $this->cookieId,
                'value' => $model->cookie,
            ]));
        }
        else {
            yii::debug($model->errors);
        }
    }
}