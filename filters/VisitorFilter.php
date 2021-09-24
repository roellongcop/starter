<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Visitor;
use yii\web\Cookie;

class VisitorFilter extends \yii\base\ActionFilter
{
    public $duration = 60 * 60 * 24;
    public $cookieId = 'app-visitor-id';
    public $exempted = [
        'file/display',
        'file/delete',
        'file/upload',
        'site/error',
    ];

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
        $expire = time() + $this->duration;

        $model = new Visitor(['expire' => $expire]);

        if ($model->save()) {
            // add a new cookie to the response to be sent
            $cookies->add(new Cookie([
                'name' => $this->cookieId,
                'value' => $model->cookie,
                'secure' => true,
                'expire' => $expire
            ]));
        }
        else {
            Yii::debug($model->errors);
        }
    }
}