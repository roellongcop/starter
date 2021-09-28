<?php

namespace app\filters;

use Yii;
use app\helpers\App;
use app\models\Visitor;
use yii\web\Cookie;
use app\models\form\UserAgentForm;

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
        $expire = time() + ($this->duration ?? App::setting('system')->auto_logout_timer);

        $userAgent = new UserAgentForm();
        $model = new Visitor([
            'expire' => $expire,
            'session_id' => App::session('id'),
            'ip' => App::ip(),
            'browser' => $userAgent->browser,
            'os' => $userAgent->os,
            'device' => $userAgent->device,
            'server' => App::server(),
            'location' => $userAgent->ipInformation,
        ]);
        $model->cookie = $model->createCookieValue();

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