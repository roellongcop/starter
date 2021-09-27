<?php

namespace tests\unit\models\form;

use app\models\form\UserAgentForm;

class UserAgentFormTest extends \Codeception\Test\Unit
{
    public function testLocation()
    {
        $model = new UserAgentForm();
        $model->ip = '114.198.145.50';
        $information = $model->ipInformation;

        expect($information)->hasKey('city');
        expect($information)->hasKey('state');
        expect($information)->hasKey('country');
        expect($information)->hasKey('country_code');
        expect($information)->hasKey('continent');
        expect($information)->hasKey('continent_code');

        expect($information['city'])->equals('');
        expect($information['state'])->equals('');
        expect($information['country'])->equals('Philippines');
        expect($information['country_code'])->equals('PH');
        expect($information['continent'])->equals('Asia');
        expect($information['continent_code'])->equals('AS');
    }

    public function testBrowser()
    {
        $model = new UserAgentForm();
        expect($model->browser)->equals('Browser not detected');
    }

    public function testOS()
    {
        $model = new UserAgentForm();
        expect($model->os)->equals('OS not detected');
    }

    public function testDevice()
    {
        $model = new UserAgentForm();
        expect($model->device)->equals('Device not detected');
    }
}