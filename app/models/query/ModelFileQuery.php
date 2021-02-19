<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\ModelFile]].
 *
 * @see \app\models\ModelFile
 */
class ModelFileQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'record_status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ModelFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ModelFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
