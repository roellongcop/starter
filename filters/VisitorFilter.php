<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Visitor;
use yii\web\Cookie;

class VisitorFilter extends \yii\base\ActionFilter
{
    public $force = false;
    public $duration;
    public $cookieId = 'app-visitor-id';
    public $exempted = [
        'file/display',
    ];

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ((!in_array(App::controllerAction(), $this->exempted) 
            && App::isWeb()
            && !App::isAjax()
            && !$this->isBot()) || $this->force) {

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
        }

        return true;
    }

    public function isBot() 
    {
        return (
            isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
        );
    }

    public function addCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $expire = time() + ($this->duration ?? App::generalSetting('auto_logout_timer'));

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