<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Faker\Factory;
use Yii;
use app\helpers\App;
use app\models\Ip;
use app\models\Role;
use app\models\Theme;
use app\models\User;
use app\models\search\RoleSearch;
use yii\helpers\Inflector;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionInit()
    {
        $this->actionTruncate(['users', 'roles', 'ips']);
        $this->actionRoles(5);
        $this->actionUsers(5, false);
        $this->actionIp(5);
    }

    public function actionIndex()
    {
        $this->actionRoles(5);
        $this->actionUsers(5, false);
        $this->actionIp(5);
    }

    
    public function actionIp($row=1)
    {
        $this->startProgress(0, $row, 'Seeding IP: ');
        for ($i=1; $i <= $row; $i++) { 
            $model = new Ip();
            $model->name = $this->faker->ipv4; 
            $model->description = $this->faker->text; 
            $model->type = $this->randomParamsID('ip_type');
            $model->created_at = $this->faker->date . ' ' . $this->faker->time;
            $model->record_status = $this->recordStatus();
            $this->save($model, $i, $row); 
        }
        $this->summary(Ip::find()->count());
    }

    public function _roleCreateNavigation($controllerActions)
    {
        $data = [];

        $count = 1;

        $controllerActions['general-setting'] = ['link' => '/setting/general'];
        $controllerActions['my-setting'] = ['link' => '/my-setting'];
        $controllerActions['my-files'] = ['link' => '/my-files'];

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

    public function actionRoles($row=1)
    {

        $controllerActions = App::component('access')->controllerActions();
        // $createNavigation = $this->_roleCreateNavigation($controllerActions);
        $createNavigation = include Yii::getAlias('@commands').'/data/navigation.php';
        $this->startProgress(0, $row, 'Seeding Role: ');
        for ($i=1; $i <= $row; $i++) { 
            $model = new Role();
            $model->name = $this->faker->jobTitle; 
            $model->module_access = $controllerActions;
            $model->main_navigation = $createNavigation;
            $model->record_status = $this->recordStatus();
            $model->created_at = $this->created_at();
            $this->save($model, $i, $row); 
        }
        $this->summary(Role::find()->count());
    }

    public function actionUsers($row=1, $random=true)
    {
        $roles = array_keys(RoleSearch::dropdown());
        $this->startProgress(0, $row, 'Seeding User: ');
        for ($i=1; $i <= $row; $i++) { 
            $model = new User();
            $model->role_id = $this->faker->randomElement($roles);
            $model->username = $this->faker->firstName;
            $model->email = $this->faker->email;
            $model->password_hash = App::hash($model->email);
            $model->password_hint = 'Same as Email';
            if ($random) {
                $model->status = $this->randomParamsID('user_status');
                $model->record_status = $this->randomParamsID('record_status');
                $model->is_blocked = $this->randomParamsID('is_blocked');
            }
            else {
                $model->status = 10;
                $model->record_status = 1;
                $model->is_blocked = 0;
            }
          
            $model->created_at = $this->created_at();
            $this->save($model, $i, $row); 
        }
        $this->summary(User::find()->count());
    } 

   
}
