<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\ModelFile]].
 *
 * @see \app\models\ModelFile
 */
class ModelFileQuery extends ActiveQuery
{
    public function controllerID()
    {
        return 'model-file';
    }
}
