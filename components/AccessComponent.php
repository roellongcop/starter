<?php

namespace app\components;

use Yii;
use app\helpers\App;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

class AccessComponent extends Component
{
	const NAVIGATIONS = [
	    '1' => [
	        'label' => 'Dashboard', 
	        'link' => '/dashboard', 
	        'icon' => '<i class="fa fa-cog"></i>',
	    ],
	    '2' => [
	        'label' => 'Users',
	        'link' => '#',
	        'icon' => '<i class="fa fa-cog"></i>',
	        'sub' => [
	            '2.1' => [
	                'label' => 'List',
	                'link' => '/user',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '2.2' => [
	                'label' => 'User Meta',
	                'link' => '/user-meta',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	        ],
	    ],
	    '3' => [
	        'label' => 'Files',
	        'link' => '#',
	        'icon' => '<i class="fa fa-cog"></i>',
	        'sub' => [
	            '3.1' => [
	                'label' => 'List',
	                'link' => '/file',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '3.2' => [
	                'label' => 'My Files',
	                'link' => '/my-files',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	        ],
	    ],
	    '4' => [
	        'label' => 'System',
	        'link' => '#',
	        'icon' => '<i class="fa fa-cog"></i>',
	        'sub' => [
	            '4.1' => [
	                'label' => 'Roles',
	                'link' => '/role',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '4.2' => [
	                'label' => 'Backups',
	                'link' => '/backup',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '4.3' => [
	                'label' => 'Sessions',
	                'link' => '/session',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '4.4' => [
	                'label' => 'Logs',
	                'link' => '/log',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '4.5' => [
	                'label' => 'Visit Logs',
	                'link' => '/visit-log',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '4.6' => [
	                'label' => 'Queues',
	                'link' => '/queue',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	        ],
	    ],
	    '5' => [
	        'label' => 'Settings',
	        'link' => '#',
	        'icon' => '<i class="fa fa-cog"></i>',
	        'sub' => [
	        	'5.0' => [
	                'label' => 'Setting List',
	                'link' => '/setting',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '5.1' => [
	                'label' => 'General Setting',
	                'link' => '/setting/general',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '5.2' => [
	                'label' => 'Ip',
	                'link' => '/ip',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ],
	            '5.3' => [
	                'label' => 'Themes',
	                'link' => '/theme',
	                'icon' => '<i class="fa fa-cog"></i>',
	            ]
	        ]
	    ],
	    '6' => [
	        'label' => 'Notifications', 
	        'link' => '/notification', 
	        'icon' => '<i class="fa fa-cog"></i>',
	    ],
	    '7' => [
	        'label' => 'Visitors', 
	        'link' => '/visitor', 
	        'icon' => '<i class="fa fa-cog"></i>',
	    ],
	];
	
	public $searchModels;
	public $controllerActions;
	public $defaultNavigation;

	public function init()
	{
		parent::init();
		$this->setSearhModels();
		$this->setControllerActions();
		$this->setDefaultNavigation();
	}

	public function setControllerActions()
	{
		$controllers = FileHelper::findFiles(Yii::getAlias('@app/controllers'), [
			'recursive' => true
		]);

		$data = [];

		foreach ($controllers as $key => $controller) {

			if (($controllerID = Inflector::camel2id(substr(basename($controller), 0, -14))) == '') continue;

			$controllerName = substr(basename($controller), 0, -4);
			$controllerObject = Yii::createObject("\\app\\controllers\\{$controllerName}");
			$actions = get_class_methods($controllerObject);
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
		$this->controllerActions = $data;
	} 

	public function actions($controllerID="")
	{ 
		$controllerID = $controllerID ?: App::controllerID();

		return $this->controllerActions[$controllerID] ?? [''];
	}

 	public function my_actions($controllerID='')
 	{
 		if (App::isGuest()) { return ['']; }

		$controllerID = $controllerID ?: App::controllerID();

 		$module_access = App::identity('moduleAccess');

 		return $module_access[$controllerID] ?? [''];
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
 
	public function userCan($action, $controllerID='', $user='')
 	{
		$controllerID = $controllerID ?: App::controllerID();

		$module_access = ($user)? $user->identity->moduleAccess: App::identity('moduleAccess');

		if (isset($module_access[$controllerID])) {
			return in_array($action, $module_access[$controllerID]) ? true: false;
		}

		return false;
 	}
 
 	public function getModuleFilter()
 	{
 		$controller_actions = $this->controllerActions;

 		$data = [];

 		$ignoreControllers = [
 			'general-setting',
 			'dashboard',
 			'site',
 			// 'api',
 			// 'model-file',
 		];

 		foreach ($controller_actions as $controller => $actions) {
 			if ($this->userCan('index', $controller) 
 				&& !in_array($controller, $ignoreControllers)) {
 				$searchModelClass = Inflector::id2camel($controller) . 'Search';

            	$path = FileHelper::normalizePath(Yii::getAlias("@app/models/search/{$searchModelClass}.php"));

 				if (file_exists($path)) {
 					$data[$searchModelClass] = Inflector::camel2words(
 						Inflector::id2camel($controller)
 					);
 				}
 			}
 		}

 		return $data;
 	}

 	public function setDefaultNavigation()
 	{
 		$this->defaultNavigation = self::NAVIGATIONS;
 	} 

	public function menu($menus)
	{
	    foreach ($menus as $key => &$menu) {
	        if (isset($menu['group_menu']) && $menu['group_menu']) {
	            unset($menus[$key]);
	        }
	        else {
	            $menu['url'] = $menu['link'];
	            unset($menu['link']);
	            if (isset($menu['sub'])) {
	                $menu['items'] = $this->menu($menu['sub']);
	                unset($menu['sub']);
	            }
	        }
	    }
	    return $menus;
	}

	public function setSearhModels()
	{
		$searchModels = FileHelper::findFiles(Yii::getAlias('@app/models/search'), [
			'recursive' => true
		]);

		$ignore = [
			'DashboardSearch',
		];

		$data = [];
		foreach ($searchModels as $key => $searchModel) {
			$name = str_replace('.php', '', basename($searchModel));

			if (! in_array($name, $ignore)) {
				$data[$name] = Inflector::camel2words(str_replace('Search', '', $name));
			}
		}

		$this->searchModels = $data;
	} 
}