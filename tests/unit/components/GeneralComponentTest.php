<?php

namespace tests\unit\components;

class GeneralComponentTest extends \Codeception\Test\Unit
{
    public $general;

    public function _before()
    {
        $this->general = \Yii::$app->general;
    }

    public function testGetAllTables()
    {
        expect($this->general->getAllTables())->equals([
            'tbl_backups' => 'tbl_backups',
            'tbl_files' => 'tbl_files',
            'tbl_ips' => 'tbl_ips',
            'tbl_logs' => 'tbl_logs',
            'tbl_migrations' => 'tbl_migrations',
            'tbl_model_files' => 'tbl_model_files',
            'tbl_notifications' => 'tbl_notifications',
            'tbl_queues' => 'tbl_queues',
            'tbl_roles' => 'tbl_roles',
            'tbl_sessions' => 'tbl_sessions',
            'tbl_settings' => 'tbl_settings',
            'tbl_themes' => 'tbl_themes',
            'tbl_user_metas' => 'tbl_user_metas',
            'tbl_users' => 'tbl_users',
            'tbl_visit_logs' => 'tbl_visit_logs',
        ]);
    }

    public function testTimezoneList()
    {
        expect($this->general->timezoneList())->hasKey('Africa/Abidjan');
    }
}