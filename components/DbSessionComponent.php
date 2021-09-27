<?php

namespace app\components;

use Yii;
use app\helpers\App;
use app\models\Session;
use yii\db\Expression;
use app\models\form\UserAgentForm;

class DbSessionComponent extends \yii\web\DbSession
{
	public function init()
	{
		$this->timeout = App::generalSetting('auto_logout_timer');
		$this->sessionTable = Session::tableName();
		$this->writeCallback = function ($session) { 
			$userAgent = new UserAgentForm();
	        return [
	            'user_id' => App::user('id'),
	            'ip' => App::ip(),
	            'browser' => $userAgent->browser,
	            'os' => $userAgent->os,
	            'device' => $userAgent->device,
	            'created_at' => new Expression('UTC_TIMESTAMP'),
	            'updated_at' => new Expression('UTC_TIMESTAMP'),
	       ];
	    };
		parent::init();
	}
}