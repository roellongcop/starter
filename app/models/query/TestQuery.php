<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Test]].
 *
 * @see \app\models\Test
 */
class TestQuery extends ActiveQuery
{

    public function controllerID()
    {
        return 'test';
    }

}
