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
        $tables = $this->general->getAllTables();

        expect($tables)->hasKey('tbl_backups');
        expect($tables)->hasKey('tbl_files');
        expect($tables)->hasKey('tbl_ips');
        expect($tables)->hasKey('tbl_logs');
        expect($tables)->hasKey('tbl_migrations');
        expect($tables)->hasKey('tbl_notifications');
        expect($tables)->hasKey('tbl_queues');
        expect($tables)->hasKey('tbl_roles');
        expect($tables)->hasKey('tbl_sessions');
        expect($tables)->hasKey('tbl_settings');
        expect($tables)->hasKey('tbl_themes');
        expect($tables)->hasKey('tbl_user_metas');
        expect($tables)->hasKey('tbl_users');
        expect($tables)->hasKey('tbl_visit_logs');
    }

    public function testTimezoneList()
    {
        expect($this->general->timezoneList())->hasKey('Africa/Abidjan');
    }
}