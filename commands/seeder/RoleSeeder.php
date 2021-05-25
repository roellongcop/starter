<?php
namespace app\commands\seeder;

use app\helpers\App;
class RoleSeeder extends Seeder
{
	public $controllerActions;

	public function __construct()
	{
		parent::__construct();
		$this->controllerActions = App::component('access')->controllerActions();
	}
	public function modelClass()
	{
		return '\app\models\Role';
	}

	public function attributes()
	{
		return [
            'name' => $this->faker->jobTitle, 
            'module_access' => $this->controllerActions,
            'main_navigation' => $this->createNavigation(),
            'record_status' => $this->recordStatus(),
            'created_at' => $this->created_at(),
		];
	}

	public function createNavigation($value='')
	{
		return [
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
		            '3.3' => [
		                'label' => 'Model Files',
		                'link' => '/model-file',
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
		            '5.1' => [
		                'label' => 'List',
		                'link' => '/setting',
		                'icon' => '<i class="fa fa-cog"></i>',
		            ],
		            '5.2' => [
		                'label' => 'My Settings',
		                'link' => '/my-setting',
		                'icon' => '<i class="fa fa-cog"></i>',
		            ],
		            '5.3' => [
		                'label' => 'General Setting',
		                'link' => '/setting/general',
		                'icon' => '<i class="fa fa-cog"></i>',
		            ],
		            '5.4' => [
		                'label' => 'Ip',
		                'link' => '/ip',
		                'icon' => '<i class="fa fa-cog"></i>',
		            ],
		            '5.5' => [
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
		];

	}
	
}