<?php
namespace app\components;


use Yii;
use app\helpers\App;
use yii\base\Component;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * 
 */
class AccessComponent extends Component
{
 
	public function controllerActions()
	{
		$controllers = FileHelper::findFiles(Yii::getAlias('@app/controllers'), [
			'recursive' => true
		]);

		$data = [];

		foreach ($controllers as $key => $controller) {

			if (($controllerID = Inflector::camel2id(substr(basename($controller), 0, -14))) == '') continue;

			$controllerName = substr(basename($controller), 0, -4);
			$actions = get_class_methods("\\app\\controllers\\{$controllerName}");
			$_actions = [];

			foreach ($actions as $action) {
				if (!preg_match("/^action\w+$/", $action)) continue;

				if (($actionID = substr(Inflector::camel2id($action), 7)) == '') continue;

				$_actions[] = $actionID;
			}

			asort($_actions);
			$data[$controllerID] = $_actions;

		}
 		ksort($data);
		return $data;
	}

	 

	public function actions($controller="")
	{ 
		if ($controller === "") {
			return $this->controllerActions()[App::controllerID()];
		} 

		$actions = $this->controllerActions();

		return $actions[$controller] ?? [''];
	}
 	
 

 	public function my_actions($controller='')
 	{
 		if (App::isGuest()) {
 			return [''];
 		}
		$controller = ($controller) ? $controller:  App::controllerID();

 		$module_access = App::identity('module_access');

 		if (!is_array($module_access)) {
 			$module_access = json_decode($module_access, true);
 		}

 		return $module_access[$controller] ?? [''];
 	}

 
 	public function userCanRoute($link='')
 	{
 		if (is_array($link)) {
            $url = $link[0];

            $explodedLink = explode('/', $url);
            if (count($explodedLink) == 1) {
                $controller = App::controllerID();
                $action = $explodedLink[0];
            }
            else {
                $controller = $explodedLink[0];
                $action = $explodedLink[1];
            }
            return $this->userCan($action, $controller);
        }
 	}
 
 
	public function userCan($action='', $controller='', $user='')
 	{
		$action = ($action === '') ? App::actionID() : $action;
		$controller = ($controller === '') ? App::controllerID() : $controller;

		$module_access = ($user)? $user->identity->module_access: App::identity('module_access');

		if (isset($module_access[$controller])) {
			return in_array($action, $module_access[$controller]) ? true: false;
		}

		return false;
 	}
 

 	public function getModuleFilter()
 	{
 		$controller_actions = $this->controllerActions();

 		$data = [];

 		$ignoreControllers = [
 			'general-setting',
 			'dashboard',
 			'site',
 			'api',
 			'model-file',
 		];

 		foreach ($controller_actions as $controller => $actions) {
 			if ($this->userCan('index', $controller) 
 				&& !in_array($controller, $ignoreControllers)) {
 				$searchModelClass = Inflector::id2camel($controller) . 'Search';

            	$path = Yii::getAlias('@app') . "/models/search/{$searchModelClass}.php";

 				if (file_exists($path)) {
 					$data[$searchModelClass] = Inflector::camel2words(
 						Inflector::id2camel($controller)
 					);
 				}
 			}
 		}

 		return $data;
 	}
 

}