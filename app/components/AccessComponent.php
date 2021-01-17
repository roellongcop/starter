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
 
	public function controllerActions($res = [])
	{
		$controllers = FileHelper::findFiles(Yii::getAlias('@app/controllers'), [
			'recursive' => true
		]);

		foreach ($controllers as $key => $controller) {
			$contents = file_get_contents($controller);
			$controller_ID = Inflector::camel2id(substr(basename($controller), 0, -14));
			preg_match_all('/public function action(\w+?)\(/', $contents, $result);
			
			$_actions = $result[1];

			asort($_actions);

			foreach ($_actions as $action) {
				$action_ID = Inflector::camel2id($action);

				if($action_ID !== 's') {
					$res[$controller_ID][] = $action_ID;
				}
			}
		}
 		ksort($res);
		return $res;
	}

	 

	public function actions($controller="")
	{ 
		if ($controller === "") {
			return $this->controllerActions()[App::controllerID()];
		} 

		$actions = $this->controllerActions();

		return $actions[$controller] ?? [''];
	}
 	

 	public function behaviors($actions=[''], $verb_actions=[])
 	{
 		return [
 			'access' => $this->_access($actions),
            'verbs' => $this->verbs($verb_actions)
        ];
 	}

 	public function verbs($verb_actions=[])
 	{
 		$actions = empty($verb_actions)? ['delete' => ['POST']] : $verb_actions;

 		return [
            'class' => VerbFilter::className(),
            'actions' => $actions,
        ];
 	}


 	public function my_actions($controller='')
 	{
 		if (App::isGuest()) {
 			return [''];
 		}
		$controller = ($controller) ? $controller:  App::controllerID();

 		$module_access = App::identity('module_access');

 		return $module_access[$controller] ?? [''];
 	}

 	public function _access($actions=[''])
 	{
 		$my_actions = $this->my_actions();

 		if ($actions) {
 			$my_actions = array_merge($my_actions, $actions);
 		}

 		return [
			'class' => AccessControl::className(),
			'only' => $this->actions(),
            'rules' => [
                [
                    // 'actions' => $this->actions(),
                    'actions' => $my_actions,
                    'allow' => true,
                    'roles' => ['@'],
				],
				[
                    'actions' => $actions,
                    'allow' => true,
                    'roles' => ['?'],
				],
            ],
		];
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


 	public function createNavigation()
 	{
 		$controllerActions = $this->controllerActions();

 		$data = [];

 		$count = 1;

 		$controllerActions['general-setting'] = ['link' => '/setting/general'];


 		foreach ($controllerActions as $controller => $actions) {
 			$data["{$count}-new"] = [
 				'label' => ucwords(str_replace('-', ' ', Inflector::titleize($controller))),
                'link' => App::urlManager('baseUrl') . (isset($actions['link'])? $actions['link']: "/{$controller}"),
 				'icon' => '<i class="fa fa-cog"></i>'
 			];
 			$count++;
 		}

		
 		return $data;
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