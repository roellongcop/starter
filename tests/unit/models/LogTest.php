<?php

namespace tests\unit\models;

use app\helpers\Url;
use app\models\Log;

class LogTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 1,
            'model_id' => 1,
            'request_data' => [
                '_csrf' => 'QRS8RhBMyW_SC_JgnkJIV1eVxNvzXQdX9rmFpI9AOKgzX8kBWz-MA7xNwlnQESI1D_Sb6aJuTTuzgLzL6nkO0Q==',
               'LoginForm' => array(
                    'username' => 'developer@developer.com',
                    'password' => 'developer@developer.com',
                ),
            ],
            'change_attribute' => [
                'user_id' => NULL,
               'ip' => NULL,
               'action' => NULL,
               'record_status' => NULL,
               'created_at' => NULL,
               'updated_at' => NULL,
               'created_by' => NULL,
               'updated_by' => NULL,
               'id' => NULL,
            ],
            'method' => 'POST',
            'url' => Url::to(['site/login'], true),
            'action' => 'login',
            'controller' => 'site',
            'table_name' => 'visit_logs',
            'model_name' => 'VisitLog',
            'ip' => '::1',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'device' => 'Computer',
            'server' => [
                'DOCUMENT_ROOT' => 'C:\laragon\www\starter\web',
                'REMOTE_ADDR' => '::1',
                'REMOTE_PORT' => '53724',
                'SERVER_SOFTWARE' => 'PHP 7.4.8 Development Server',
                'SERVER_PROTOCOL' => 'HTTP/1.1',
                'SERVER_NAME' => 'localhost',
                'SERVER_PORT' => '8080',
                'REQUEST_URI' => '/dashboard',
                'REQUEST_METHOD' => 'GET',
                'SCRIPT_NAME' => '/index.php',
                'SCRIPT_FILENAME' => 'C:\laragon\www\starter\web\index.php',
                'PATH_INFO' => '/dashboard',
                'PHP_SELF' => '/index.php/dashboard',
                'HTTP_HOST' => 'localhost:8080',
                'HTTP_CONNECTION' => 'keep-alive',
                'HTTP_CACHE_CONTROL' => 'max-age=0',
                'HTTP_SEC_CH_UA' => '" Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"',
                'HTTP_SEC_CH_UA_MOBILE' => '?0',
                'HTTP_UPGRADE_INSECURE_REQUESTS' => '1',
                'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Safari/537.36',
                'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'HTTP_SEC_FETCH_SITE' => 'none',
                'HTTP_SEC_FETCH_MODE' => 'navigate',
                'HTTP_SEC_FETCH_USER' => '?1',
                'HTTP_SEC_FETCH_DEST' => 'document',
                'HTTP_ACCEPT_ENCODING' => 'gzip, deflate, br',
                'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.9,la;q=0.8',
                'HTTP_COOKIE' => '_ga=GA1.1.407239226.1600821663; debug-bar-tab=ci-timeline; debug-bar-state=minimized; fpestid=Ff_-ZGvswuV27XqYVgDFEd0fvEqQ7pasvbVfIEO5DQpJWsJaQ1bzIX9beYi6_HEfIAqd8g; PHPSESSID=n7mqbe78d7vrjdcun8m9oqvd11; _csrf=7e359696465f5ba6fd7b8c33041c4d6d4b96d48272cbe12371c3131ea84dfb69a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22WMOrqqjCkes0q4R86NNyOyJE_ZkduEj_%22%3B%7D',
                'REQUEST_TIME_FLOAT' => 1623125700.650181,
                'REQUEST_TIME' => 1623125700,
            ],
            'updated_by' => 1,
            'created_by' => 1,
            'record_status' => Log::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Log($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Log::RECORD_INACTIVE]);

        $model = new Log($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Log($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testCreateNoData()
    {
        $model = new Log();
        expect_not($model->save());
    }

    public function testCreateInvalidUserId()
    {
        $data = $this->data(['user_id' => 100]);
        $model = new Log($data);

        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Log', ['record_status' => Log::RECORD_ACTIVE]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Log', ['record_status' => Log::RECORD_INACTIVE]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Log', ['record_status' => Log::RECORD_ACTIVE]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}