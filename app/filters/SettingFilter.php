<?php
namespace app\filters;

use Yii;
use app\helpers\App;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\base\ActionFilter;

class SettingFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $options = Json::htmlEncode([
            'appName' => App::appName(),
            'baseUrl' => Url::base(true) . '/',
            'language' => App::appLanguage(),
            'api' => Url::base(true) . '/api/v1/',
            'csrfToken' => App::request('csrfToken'),
            'csrfParam' => App::request('csrfParam'),
            'params' => App::params()
        ]);

        $this->view->registerJs("
            var app = {$options};
            console.log(app)
        ", \yii\web\View::POS_HEAD, 'app');
        
        App::session()->timeout = App::setting('auto_logout_timer');
        
        return true;
    }
}