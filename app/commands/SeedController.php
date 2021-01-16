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
use yii\console\Controller;
use yii\console\ExitCode;

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
    public $success = 0;
    public $failed = 0;
    public $print_attributes = false;

    public function truncate($tables=[])
    {
        foreach ($tables as $table) {
            echo "\nTruncate {$table}";
            Yii::$app->db->createCommand()
                ->truncateTable(Yii::$app->db->tablePrefix . $table)
                ->execute();
        }
    }

    public function actionFresh()
    {
        $this->truncate([
            'roles',
            'users',
        ]);
        $this->actionIndex();
    }

    public function actionIndex()
    {
        $this->actionRoles(10);
        $this->actionUsers(10, false);
        $this->actionThemes();
    }

    public function actionThemes()
    {
        $themes = require __DIR__ . '/themes.php';
        Yii::$app->db->createCommand()
            ->truncateTable(Yii::$app->db->tablePrefix . 'themes')
            ->execute();
        echo ("\n= Seeding Themes =\n");
        foreach ($themes as $i => $theme) {
            $data = [
                'description' => $theme['description'],
                'name' => $theme['name'],
                'base_path' => $theme['basePath'],
                'base_url' => $theme['baseUrl'],
                'path_map' => $theme['pathMap'],
                'bundles' => $theme['bundles'] ?? NULL,
            ];
            $model = new Theme();
            $model->load(['Theme' => $data]);
            $this->save($model, $i); 
        }
        $this->summary(Theme::find()->count());
    }

    public function actionIp($row=1)
    {
        $faker = Factory::create();
        echo ("\n= Seeding ip =\n");
        for ($i=1; $i <= $row; $i++) { 
            $model                  = new Ip();
            $model->name            = $faker->ipv4; 
            $model->description     = $faker->text; 
            $model->type            = $faker->randomElement(App::keyMapParams('ip_type'));
            $model->created_at = $faker->date . ' ' . $faker->time;
            $this->save($model, $i); 
        }
        $this->summary(Ip::find()->count());
    }

    public function actionRoles($row=1)
    {
        $faker = Factory::create();
        $controllerActions = Yii::$app->access->controllerActions();
        $createNavigation = Yii::$app->access->createNavigation();
        echo ("\n= Seeding roles =\n");
        for ($i=1; $i <= $row; $i++) { 
            $model                  = new Role();
            $model->name            = $faker->jobTitle;
            $model->record_status   = $faker->randomElement(App::keyMapParams('record_status'));
            $model->module_access   = $controllerActions;
            $model->main_navigation = $createNavigation;
            $model->record_status   = $faker->randomElement(App::keyMapParams('record_status'));
            $model->created_at = $faker->date . ' ' . $faker->time;
            $this->save($model, $i); 
        }
        $this->summary(Role::find()->count());
    }

    public function actionUsers($row=1, $random=true)
    {
        $roles = array_keys(RoleSearch::dropdown());
        $faker = Factory::create();
        echo ("\n= Seeding users =\n");
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

            $this->save($model, $i); 
        }
        $this->summary(User::find()->count());
    } 

    // ==========================================================================================
    public function save($model, $row=1, $validation=true)
    {
        if ($this->print_attributes) {
            print ("===================== SEEDING ROW {$row} =====================\n");
        }
        else {
            print ".";
        }
        
        if ($model->save($validation)) {
            $this->success++;

            if ($this->print_attributes) {
                print_r([
                    'status' => 'success',
                    'attributes' => $model->attributes
                ]);
            }
        }
        else {
            $this->failed++;
            if ($this->print_attributes) {
                print_r([
                    'status' => 'failed',
                    'errors' => $model->errors,
                    'attributes' => $model->attributes
                ]);
            }
        }
        return $model;
    }

    

    public function summary($total=0)
    {
        echo ("\n= SUMMARY =\n");
        echo "Success: " . number_format($this->success);
        echo "\nFailed: " . number_format($this->failed);
        echo "\nTotal: " . number_format($total);
        echo "\n\n\n";

        $this->success = 0;
        $this->failed = 0;

        return ExitCode::OK;
    }
 

}
