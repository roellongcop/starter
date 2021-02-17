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
        $this->actionRoles(10);
        $this->actionUsers(10, false);
        $this->actionThemes();
    }

    public function actionIndex()
    {
        $this->actionRoles(10);
        $this->actionUsers(10, false);
        $this->actionThemes();
        $this->actionIp(100);
    }

    
    public function actionThemes()
    {
        $themes = require __DIR__ . '/themes.php';
        $this->actionTruncate(['themes']);
        $this->startProgress(0, count($themes), 'Seeding Themes: ');
        foreach ($themes as $i => $theme) {
            $data = [
                'description' => $theme['description'],
                'name' => $theme['name'],
                'base_path' => $theme['basePath'],
                'base_url' => $theme['baseUrl'],
                'path_map' => $theme['pathMap'],
                'bundles' => $theme['bundles'] ?? NULL,
                'record_status' => 1,
            ];
            $model = new Theme();
            $model->load(['Theme' => $data]);
            $this->save($model, $i, count($themes)); 
        }
        $this->summary(Theme::find()->count());
    }

    public function actionIp($row=1)
    {
        $faker = Factory::create();
        $this->startProgress(0, $row, 'Seeding IP: ');
        for ($i=1; $i <= $row; $i++) { 
            $model                  = new Ip();
            $model->name            = $faker->ipv4; 
            $model->description     = $faker->text; 
            $model->type            = $faker->randomElement(App::keyMapParams('ip_type'));
            $model->created_at = $faker->date . ' ' . $faker->time;
            $model->record_status   = $faker->randomElement(App::keyMapParams('record_status'));
            $this->save($model, $i, $row); 
        }
        $this->summary(Ip::find()->count());
    }

    public function actionRoles($row=1)
    {
        $faker = Factory::create();
        $controllerActions = Yii::$app->access->controllerActions();
        $createNavigation = Yii::$app->access->createNavigation();
        $this->startProgress(0, $row, 'Seeding Role: ');
        for ($i=1; $i <= $row; $i++) { 
            $model                  = new Role();
            $model->name            = $faker->jobTitle;
            $model->record_status   = $faker->randomElement(App::keyMapParams('record_status'));
            $model->module_access   = $controllerActions;
            $model->main_navigation = $createNavigation;
            $model->record_status   = $faker->randomElement(App::keyMapParams('record_status'));
            $model->created_at = $faker->date . ' ' . $faker->time;
            $this->save($model, $i, $row); 
        }
        $this->summary(Role::find()->count());
    }

    public function actionUsers($row=1, $random=true)
    {
        $roles = array_keys(RoleSearch::dropdown());
        $faker = Factory::create();
        $this->startProgress(0, $row, 'Seeding User: ');
        for ($i=1; $i <= $row; $i++) { 
            $model                = new User();
            $model->role_id       = $faker->randomElement($roles);
            $model->username      = $faker->firstName;
            $model->email         = $faker->email;
            $model->password_hash = App::hash($model->email);
            $model->password_hint = 'Same as Email';
            if ($random) {
                $model->status        = $faker->randomElement(App::keyMapParams('user_status'));
                $model->record_status = $faker->randomElement(App::keyMapParams('record_status'));
                $model->is_blocked    = $faker->randomElement(App::keyMapParams('is_blocked'));
            }
            else {
                $model->status        = 10;
                $model->record_status = 1;
                $model->is_blocked    = 0;
            }
          

            $model->created_at = $faker->date . ' ' . $faker->time;

            $this->save($model, $i, $row); 
        }
        $this->summary(User::find()->count());
    } 

   
}
