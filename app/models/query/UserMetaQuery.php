<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\UserMeta]].
 *
 * @see \app\models\UserMeta
 */
class UserMetaQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([
            'record_status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\UserMeta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\UserMeta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
