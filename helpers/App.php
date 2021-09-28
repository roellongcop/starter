<?php

namespace app\helpers;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException; 

class App {

	public static function app()
	{
		return Yii::$app;
	}

	public static function timestamp()
	{
		return new Expression('UTC_TIMESTAMP');
	}

	public static function isLogin()
	{
		return ! self::isGuest();
	}

	public static function session($obj='')
	{
		if ($obj == '') {
			return self::app()->session;
		}
		return self::app()->session->{$obj} ?? '';
	}

	public static function security()
	{
		return self::app()->security;
	}

	public static function randomString($length=10)
	{
        return self::security()->generateRandomString($length);
	}

	public static function hash($string='')
	{
		return self::security()->generatePasswordHash($string);
	}
	
	public static function request($obj='')
	{
		if ($obj == '') {
			return self::app()->request;
		}
		return self::app()->request->{$obj};
	}

	public static function response($obj='')
	{
		if ($obj == '') {
			return self::app()->response;
		}
		return self::app()->response->{$obj};
	}

	public static function view($obj='')
	{
		if ($obj == '') {
			return self::app()->view;
		}
		return self::app()->view->{$obj};
	}


	public static function assetManager($obj='')
	{
		if ($obj == '') {
			return self::app()->assetManager;
		}
		return self::app()->assetManager->{$obj};
	}



	public static function component($component)
	{
		return self::app()->{$component};
	}

	public static function queryParams($key='')
	{
		if ($key == '') {
			return self::request()->queryParams;
		}

		return self::request()->queryParams[$key] ?? '';
	}

	public static function referrer()
	{
		return self::request()->referrer ?? '';
	}

	public static function post($key = '')
	{
		if ($key == '') {
			return self::request()->post();
		}
		return self::request()->post($key) ?? '';
	}

	public static function get($key = '')
	{
		if ($key == '') {
			return self::request()->get();
		}
		return self::request()->get($key) ?? '';
	}

	public static function user($obj='')
	{
		if ($obj == '') {
			return self::app()->user;
		}
		return self::app()->user->{$obj} ?? '';
	}

	public static function identity($obj='')
	{
		if ($obj == '') {
			return self::user()->identity;
		}
		return self::user()->identity->{$obj} ?? '';
	}


	public static function isGuest()
	{
		return self::user()->isGuest;
	}

	public static function params($key = '')
	{
		if ($key == '') {
			return self::app()->params;
		}

		return self::app()->params[$key] ?? '';
	}

	public static function controller($attr='')
	{
		if ($attr) {
			return self::app()->controller->{$attr};
		}
		return self::app()->controller;
	}

	public static function controllerID()
	{
		return self::controller() ? self::controller()->id: 'console';
	}

	public static function controllerAction()
	{
		return implode('/', [
			self::controllerID(),
			self::actionID(),
		]);
	}

	public static function isControllerAction($ca)
	{
		return $ca == self::controllerAction();
	}

	public static function action()
	{
		return self::controller() ? self::controller()->action: '';
	}

	public static function actionID()
	{
		return self::action() ? self::action()->id: 'index';
	}

	public static function isAction($action='')
	{
		return self::actionID() == $action;
	}

	public static function isController($controller='')
	{
		return self::controllerID() == $controller;
	}

	public static function partialLayout($file='', $params=[], $layout_path="layouts")
	{
		return self::partial("/{$layout_path}/{$file}", $params);
	}

	public static function layout($file='', $params=[])
	{
		return self::partialLayout($file, $params);
	}

	public static function partial($file_with_controller='', $params=[])
	{
		return self::controller()->renderPartial($file_with_controller, $params);
	}

	public static function errorHandler($obj='')
	{
		if ($obj == '') {
			return self::app()->errorHandler;
		}
		return self::app()->errorHandler->{$obj} ?? '';
	}

	public static function exception($obj='')
	{
		if ($obj == '') {
			return self::errorHandler()->exception;
		}
		return self::errorHandler()->exception->{$obj} ?? '';
	}


	public static function baseUrl($obj='')
	{
		if ($obj == '') {
			return self::urlManager()->baseUrl;
		}

		return self::urlManager()->baseUrl . "/{$obj}";
	}

	public static function urlManager($obj='')
	{
		if ($obj == '') {
			return self::app()->urlManager;
		}
		return self::app()->urlManager->{$obj} ?? '';
	}


	public static function absoluteUrl()
	{
		return self::request()->absoluteUrl;
	}

	public static function getMethod()
	{
		return self::request()->method;
	}

	public static function getBodyParams()
	{
		return self::request()->getBodyParams() ?? [];
	}

	public static function isAjax()
	{
		return self::request()->isAjax;
	}

	public static function loginUser($user, $remember_key=0)
	{
		return self::user()->login($user, $remember_key);
	}

    public static function db($obj='')
    {
    	if ($obj == '') {
    		return self::app()->db;
    	}
		return self::app()->db->{$obj} ?? '';
    }

    public static function tablePrefix()
    {
    	return self::db()->tablePrefix;
    }

    public static function createCommand($sql='')
    {
    	if ($sql == '') {
    		return self::db()->createCommand();
    	}
		return self::db()->createCommand($sql) ?? '';
    }

    public static function execute($sql)
    {
    	return self::createCommand($sql)->execute();
    }

    public static function query($sql)
    {
    	return self::createCommand($sql)->query();
    }

    public static function queryOne($sql)
    {
    	return self::createCommand($sql)->queryOne();
    }

    public static function truncateTable($table_name='')
    {
    	self::createCommand()->truncateTable($table_name)->execute();
    }

    public static function generateRandomKey($array=[])
    {
        $rand_key = rand(1, 99999);

        if (in_array($rand_key, $array)) {
            return self::generateRandomKey($array);
        }
        $array[] = $rand_key;
        
        return $array;
    }

    public static function success($message='')
    {
    	$message = (is_array($message))? json_encode($message): $message;
        self::session()->addFlash('success', $message);
    }

    public static function danger($message='')
    {
    	$message = (is_array($message))? json_encode($message): $message;
        self::session()->addFlash('danger', $message);
    }


    public static function info($message='')
    {
    	$message = (is_array($message))? json_encode($message): $message;
        self::session()->addFlash('info', $message);
    }

    public static function primary($message='')
    {
    	$message = (is_array($message))? json_encode($message): $message;
        self::session()->addFlash('primary', $message);
    }
    public static function warning($message='')
    {
    	$message = (is_array($message))? json_encode($message): $message;
        self::session()->addFlash('warning', $message);
    }

    public static function modelCannot($model, $action='')
    {
        return ! self::can($model, $action);
    }

	public static function modelCan($model, $action='')
	{
		if ($model) {
	        $action = Inflector::id2camel(($action ?: self::actionID()));

			$action = "can{$action}";

			if ($model->hasProperty($action)) {
	            return $model->{$action};
	        }
	        else {
	            return true;
	        }
		}
		
		return false;
	}

	public static function dateRange($date_range, $return='start')
    {
        $dates = explode( ' - ', $date_range);
        $start = date("Y-m-d", strtotime($dates[0]) ); 
        $end = date("Y-m-d", strtotime($dates[1]) ); 

        if ($return == 'start') {
            return $start;
        }

        if ($return == 'end') {
            return $end;
        }
    }

    public static function getModelName($model)
    {
        $_class_name = explode("\\", get_class($model)); 

        return end($_class_name);
    }

    public static function ip()
	{
		return App::request('userIp') ?: '000.000.0.0';
	}
	
	public static function userAgent()
	{
		return App::request('userAgent');
	}

    public static function tableExist($table_name)
    {
    	if (self::db()->getTableSchema($table_name, true) === null) {
            return false;
        }
        return true;
    }

    public static function logout()
    {
    	return self::user()->logout();
    }

    public static function className($model)
    {
        $_class_name = explode("\\", get_class($model));

        $class_name = end($_class_name);
    	
    	return $class_name;
    }
    
	public static function createUrl($path, $params=[])
	{
		$path = "{$path}&" . http_build_query($params);
		return \app\helpers\Url::to($path, true);
	}

	public static function include($file='', $params=[], $layout_path="_includes")
	{
		return self::partial("/{$layout_path}/{$file}", $params);
	}

	public static function tableName($model, $prefix=true)
	{
		if ($prefix) {
			return $model::getTableSchema()->name;
		}

		return str_replace(['{{', '%', '}}'], '', $model->tableName());
	}

	public static function schema($obj='')
	{
		if ($obj == '') {
    		return self::db()->schema;
    	}
		return self::db()->schema->{$obj} ?? '';
	}

	public static function getTableNames()
	{
		return self::schema()->getTableNames();
	}

	public static function publishedUrl($path='')
	{
		return self::app()->assetManager->getPublishedUrl(
			self::app()->view->theme->basePath
		) . $path;
	}

	public static function appName()
	{
		return self::app()->name;
	}

	public static function appLanguage()
	{
		return self::app()->language;
	}

	public static function uniqueId()
	{
		return self::action()->uniqueId;
	}

	public static function formatter($functionName='', $value='')
	{
		$formatter = self::component('formatter');
		
		if ($functionName) {
			return $formatter->$functionName($value);
		}

		return $formatter;
	}

	public static function queue($attr='')
	{
		if ($attr) {
			return self::component('queue')->{$attr};
		}
		return self::component('queue');
	}

	public static function setting($attr='')
	{
		if ($attr) {
			return self::component('setting')->{$attr};
		}
		return self::component('setting');
	}

	public static function access($attr='')
	{
		if ($attr) {
			return self::component('access')->{$attr};
		}
		return self::component('access');
	}

	public static function export($attr='')
	{
		if ($attr) {
			return self::component('export')->{$attr};
		}
		return self::component('export');
	}

	public static function file($attr='')
	{
		if ($attr) {
			return self::component('file')->{$attr};
		}
		return self::component('file');
	}

	public static function server($attr='')
	{
		if ($attr) {
			return $_SERVER[$attr] ?? '';
		}

		return $_SERVER;
	}

	public static function isConsole()
	{
		return self::app()->id == 'basic-console';
	}

	public static function isWeb()
	{
		return self::app()->id == 'yii2-basic-starter';
	}

	public static function isTest()
	{
		return self::app()->id == 'basic-tests';
	}

	public static function mapParams($params, $key='id', $value='label')
    {
       return ArrayHelper::map($params, $key, $value);
    }
}